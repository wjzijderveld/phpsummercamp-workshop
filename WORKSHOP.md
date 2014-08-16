# PHPSummercamp workshop - Build a schematic CMS in 3 hours with only PHPCR

## Introduction

- What is PHPCR
- A short history lesson
- Why PHPCR

## Part 1: Creating a simple PHPCR based website

### Introduction

- Short introduction about the box + installing jackrabbit and phpcr-shell
- Start jackrabbit
- Launch PHPCR-Shell
- Short introduction of phpcr-shell
    - node:list
    - node:create
    - node:property:set
    - file:import
    - workspace:create + list
    - session:save !!
- Setting up the session, basics like getRootNode, hasNode, hasProperty, isNodeType

### Goals

- Create some pages for a simple company website
- /cms
    + /homepage
        - title: ?
        - content; ?
    + /about
        - title: ?
        - content: ?
    + /press
        - title: ?
        - content: ?
        + /media
            + /envil.gif
            + /explosive-tennisballs.jpg
    + /policy.pdf
- Composer install in /cms
- Bootstrap a index.php application in /cms/web directory
- Setup the PHPCR session to Jackrabbit
- Display some of the content in your webbrowser based on the `REQUEST_URI`, skip nt:file for now.

## Part 2

### Introduction

- Introduction to NodeTypes, nt:unstructured, nt:file etc
- Adding a custom namespace + nodeType (nt:simple_page)
- Some tips on serving images
    - separate 'route' (/resource.php)
    - Just render them as base64 encoded data, because YOLO

### Goal

Show an image 'gallery' on the media page with the 2 imported images.


 - Add a simple menu
     - Choose a approach: properties to include/exclude, or a separate tree for menuitems

## Part 3

### Introduction

 - jcr:uuid
 - Using referencing to create custom routes

### Goal

Create a menu on your site. You can choose your own solution.


## Part 4

### Introduction

### Goal

Add versioning to your app, add a dropdown to your site where you can select the history.






## Part 5 - Bonus


### Goal

Add multilanguage support

 - Add basic multilanguage support to your content
     - Can be based on properties or childnodes
     - Can be dependent on URL prefix

















# TODO's

- Create fixture data + resources (image/pdf)
- Try out each step
- Create reset.sh scripts for each task


# Commands to remember

Export workspace to file:
`session:export:view /cms /vagrant/util/export-partX.xml`



