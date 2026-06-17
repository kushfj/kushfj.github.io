# README.md

Repository for person website. Site is live at [https://kushfj.github.io/](https://kushfj.github.io/) published a GitHub Pages. Site is generated using Hugo.

## Pre-requisites

Debian development environment is used for local development so instructions are only provided for setting up development environment on Debian. This only needs to be done once. Assuming `git` is already installed and configured.

* Install Hugo - [https://github.com/8hobbies/hugo-apt](https://github.com/8hobbies/hugo-apt)
  * `sudo apt install hugo`
* Create Hugo site inside the `src/` directory
  * `cd src/`
  * `hugo new site . -f yml --force` # we need --force since we already have some content inside src/ directory
* Install BeautifulHugo theme
  * `git submodule add --depth=1 https://github.com/halogenica/beautifulhugo.git themes/beautifulhugo`
* Modify the `config.yml` file
```bash
sed -i 's/^languageCode:[[:space:]]*en-us/locale: en-au/' config.yml
sed -i 's/^baseURL:.*/baseURL: http:\/\/kush\.com\.fj\//' config.yml
sed -i 's/^title:.*/title: 'Kush, Nishchal'/' config.yml
sed -i -e '0,/^theme:/s/^theme:.*/theme: "beautifulhugo"/;t' \ 
       -e '/^title:/a theme: "beautifulhugo"' config.yml
```
## Structure

## Create a Blog Post

Always create a new branch as we don't make changes to main/master. In the example below the new branch is called `version6` which is then merged into main/master to cause GitHub Action to execute and deploy the content

  * Create new branch
    * `git branch version6`
  * Create new content
    * `hugo new content content/post/2025-01-03-version6.md`
    * Markdown changes to the generated file
    * `git add content/post/2025-01-03-version6.md`
    * `git commit content/post/2025-01-03-version6.md -m "initial version"`
  * Merge the new branch back into the main trunk
    * `git checkout main`
    * `git merge version6`
    * `git push`

## Local Verification

Generate HTML content locally and manually verify site, post, and content presentation

  * `hugo -D -E -F --enableGitInfo --gc --logLevel "debug" --environment "production"`


## Known Issues

* Missing `theme` in `config.yml`
```shell
WARN 2026/06/11 15:10:29 found no layout file for "HTML" for kind "home": You should create a template file which matches Hugo Layouts Lookup Rules for this combination.
WARN 2026/06/11 15:10:29 found no layout file for "HTML" for kind "taxonomy": You should create a template file which matches Hugo Layouts Lookup Rules for this combination.
WARN 2026/06/11 15:10:29 found no layout file for "HTML" for kind "taxonomy": You should create a template file which matches Hugo Layouts Lookup Rules for this combination.
```

Resolved by adding `theme: 'beautifulhugo` into `config.yml` file


* 
```shell
WARN 2026/06/11 15:12:53 Module "beautifulhugo" is not compatible with this Hugo version; run "hugo mod graph" for more information.
Error: add site dependencies: load resources: loading templates: "/home/parallels/Documents/development/kushfj.github.io/src/themes/beautifulhugo/layouts/partials/seo/structured/recipe.html:71:1": parse failed: template: partials/seo/structured/recipe.html:71: unexpected <with> in else
```

Resolved by upgrading HugoGo to latest version (version 0.163)


# GitHub Actions

## hugo.yml

```yaml
name: Build and deploy
on:
  push:
    branches:
      - main
  workflow_dispatch:
permissions:
  contents: read
  pages: write
  id-token: write
concurrency:
  group: pages
  cancel-in-progress: false
defaults:
  run:
    shell: bash
jobs:
  build:
    runs-on: ubuntu-latest
    env:
      DART_SASS_VERSION: 1.101.0
      GO_VERSION: 1.26.4
      HUGO_VERSION: 0.163.2
      NODE_VERSION: 26.3.0
      TZ: Australia/Brisbane
    steps:
      - name: Checkout code
        uses: actions/checkout@v6
        with:
          submodules: recursive
          fetch-depth: 0
      - name: Setup Go
        uses: actions/setup-go@v6
        with:
          go-version: ${{ env.GO_VERSION }}
          cache: false
      - name: Setup Node.js
        uses: actions/setup-node@v6
        with:
          node-version: ${{ env.NODE_VERSION }}
      - name: Setup Pages
        id: pages
        uses: actions/configure-pages@v6
      - name: Create directory for user-specific executable files
        run: |
          mkdir -p "${HOME}/.local"
      - name: Install Dart Sass
        run: |
          curl -sLJO "https://github.com/sass/dart-sass/releases/download/${DART_SASS_VERSION}/dart-sass-${DART_SASS_VERSION}-linux-x64.tar.gz"
          tar -C "${HOME}/.local" -xf "dart-sass-${DART_SASS_VERSION}-linux-x64.tar.gz"
          rm "dart-sass-${DART_SASS_VERSION}-linux-x64.tar.gz"
          echo "${HOME}/.local/dart-sass" >> "${GITHUB_PATH}"
      - name: Install Hugo
        run: |
          curl -sLJO "https://github.com/gohugoio/hugo/releases/download/v${HUGO_VERSION}/hugo_extended_${HUGO_VERSION}_linux-amd64.tar.gz"
          mkdir "${HOME}/.local/hugo"
          tar -C "${HOME}/.local/hugo" -xf "hugo_extended_${HUGO_VERSION}_linux-amd64.tar.gz"
          rm "hugo_extended_${HUGO_VERSION}_linux-amd64.tar.gz"
          echo "${HOME}/.local/hugo" >> "${GITHUB_PATH}"
      - name: Verify installations
        run: |
          echo "Dart Sass: $(sass --version)"
          echo "Go: $(go version)"
          echo "Hugo: $(hugo version)"
          echo "Node.js: $(node --version)"
      - name: Install Node.js dependencies
        run: |
          [[ -f package-lock.json || -f npm-shrinkwrap.json ]] && npm ci || true
      - name: Configure Git
        run: |
          git config --global core.quotepath false
      - name: Cache restore
        id: cache-restore
        uses: actions/cache/restore@v5
        with:
          path: ${{ runner.temp }}/hugo_cache
          key: hugo-${{ github.run_id }}
          restore-keys:
            hugo-
      - name: Build the site
        working-directory: ./src
        run: |
          hugo build \
            --gc \
            --minify \
            --baseURL "${{ steps.pages.outputs.base_url }}/" \
            --cacheDir "${{ runner.temp }}/hugo_cache"
      - name: Cache save
        id: cache-save
        uses: actions/cache/save@v5
        with:
          path: ${{ runner.temp }}/hugo_cache
          key: ${{ steps.cache-restore.outputs.cache-primary-key }}
      - name: Upload artifact
        uses: actions/upload-pages-artifact@v5
        with:
          path: ./src/public
  deploy:
    environment:
      name: github-pages
      url: ${{ steps.deployment.outputs.page_url }}
    runs-on: ubuntu-latest
    needs: build
    steps:
      - name: Deploy to GitHub Pages
        id: deployment
        uses: actions/deploy-pages@v5
```
