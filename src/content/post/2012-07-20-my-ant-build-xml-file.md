---
author: Nishchal Kush
published: '2012-07-20T10:52:00+10:00'
slug: 2012-07-20-my-ant-build-xml-file
tags:
- jar
- code
- target
- development
- ant
- build
- build.xml
- java
title: My ant build.xml file
---
I am doing some development work using Java and am using ant to build my
code. Decided to post a copy of the build.xml file here... sorry about
the formatting  
  
  

    <project name="TODO-PROJ-NAME" basedir="." default="main">
        <property name="username"    value="TODO-USERNAME"/>
        <property name="proj.name"   value="TODO-PROJ-NAME"/>
        <property name="proj.ver"    value="TODO-VER"/>
        <property name="proj.owner"  value="TODO-COPYRIGHT"/>

        <tstamp>
            <format property="TODAY" pattern="yyyy-MM-dd HH:mm:ss" />
        </tstamp>
        
        <property name="src.dir"     value="src"/>
        <property name="build.dir"   value="bin"/>
        <property name="lib.dir"     value="lib"/>
        <property name="classes.dir" value="${build.dir}/classes"/>
        <property name="jar.dir"     value="${build.dir}/jar"/>
        <property name="javadoc.dir"     value="${build.dir}/javadoc"/>

        <property name="main-class"  value="fj.com.kush.ui.TODO-PROJ"/>

        <path id="project.classpath">
     <fileset dir="${lib.dir}">
      <include name="*.jar"/>
     </fileset>
            <pathelement path="${classes.dir}"/>
        </path>


        <target name="clean">
            <delete dir="${build.dir}"/>
            <delete>
                <fileset dir="." includes="**/*~" defaultexcludes="false"/>
            </delete>     
        </target>


        <target name="compile">
            <mkdir dir="${classes.dir}"/>
     <javac destdir="${classes.dir}" includeantruntime="false" debug="true" debuglevel="lines, vars, and source">
      <src path="${src.dir}"/>
      <classpath refid="project.classpath"/>
     </javac>
        </target>


        <target name="javadoc">
            <mkdir dir="${javadoc.dir}"/>
     <javadoc destdir="${javadoc.dir}">
                    <fileset dir="${src.dir}"/>
            </javadoc>
        </target>


        <target name="release" depends="jar, javadoc" description="make a new release of the project"/>


        <target name="copy.properties">
     <mkdir dir="${classes.dir}"/>

     <patternset id="properties.files">
      <include name="**/*.properties"/>
     </patternset>

     <copy todir="${classes.dir}">
      <fileset dir="${src.dir}">
       <patternset refid="properties.files"/>
      </fileset>
     </copy>
        </target>


        <target name="jar" depends="compile,copy.properties">
            <mkdir dir="${jar.dir}"/>
     <jar destfile="${jar.dir}/${ant.project.name}.jar" basedir="${classes.dir}">
                <manifest>
      <attribute name="Implementation-Title" value="${proj.name}"/>
      <attribute name="Implementation-Version" value="${proj.ver}"/>
      <attribute name="Implementation-Vendor" value="${proj.owner}"/>
                    <attribute name="Main-Class" value="${main-class}"/>
      <attribute name="Built-By" value="${username}"/>
      <attribute name="Built-Date" value="${TODAY}"/>
      <attribute name="Class-Path" value="./"/>
                </manifest>
            </jar>
        </target>


        <target name="run" depends="jar">
            <java jar="${jar.dir}/${ant.project.name}.jar" fork="true"/>
        </target>


        <target name="clean-build" depends="clean,jar"/>


        <target name="main" depends="clean,run"/>
    </project>
