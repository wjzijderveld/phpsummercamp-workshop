# PHPSummercamp workshop - Build a schematic CMS in 3 hours with only PHPCR 

## Introduction

- What is PHPCR
- A short history lesson
- Why PHPCR

## Part 1: Using phpcr-shell to create content

- Short introduction about the box + installing jackrabbit and phpcr-shell
- Short introduction of phpcr-shell
    - node:list
    - node:create
    - node:property:set
    - file:import
    - workspace:create + list
    - session:save

### Part 1

- Start jackrabbit
- Install and launch PHPCR-Shell

- Create some pages for a simple company website
    - Homepage
    - About
    - Press
        - Media
            - envil.gif
            - explosive-tennisballs.jpg
    - policy.pdf
- Bootstrap a single file application
    - Setup the PHPCR session to Jackrabbit
- Display some of the content in your webbrowser. Can be hardcoded for now.


### Part 2

- Create a simple controller that maps the REQUEST_URI to the path of the node
    - Start extracting to separate classes

- Make sure you have a way to serve the images and pdf
- Add a simple menu

### Part 3

- Create a custom nodeType
- Use that nodeType to render blocks on a page


### Part 4 - when time allows us

- Add basic multilanguage support to your content
    - Can be based on properties or childnodes
    - Can be dependent on URL prefix

















# TODO's

- Create fixture data + resources (image/pdf)
- Try out each step
- Create reset.sh scripts for each task


# Commands to remember

Export workspace to file:
`session:export:view /cms /vagrant/util/export-partx.xml`
