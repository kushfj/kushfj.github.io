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
sed -i 's/^languageCode:[[:space:]]*en-us/languageCode: en-au/' config.yml
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
    * `git checkout master`
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
