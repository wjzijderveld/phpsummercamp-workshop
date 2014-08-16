# PHPSummercamp workshop - Build a schematic CMS in 3 hours with only PHPCR

## Introduction

- What is PHPCR
- A short history lesson
- Why PHPCR

## Part 1: Creating a simple PHPCR based website

Estimated time introduction + goals: 45min

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

- Create some pages for a simple company website (keep it simple, we'll replace them later)
    + /cms
        + /homepage
            - title: ?
            - content; ?
        + /about
            - title: ?
            - content: ?
- Composer install in /cms
- Bootstrap a index.php application in /cms/web directory
- Setup the PHPCR session to Jackrabbit
- Display the content pages in your webbrowser based on the `REQUEST_URI`, skip nt:file nodes for now.

## Part 2 - Structure your content

### Introduction

- Introduction to NodeTypes, nt:unstructured, nt:file etc
- Adding a custom nodeType (nt:simple_page)
- Some options for serving images
    - separate 'route' (/resource.php)
    - Just render them as base64 encoded data, because YOLO

### Goal

Create the `nt:simple_page` NodeType and replace `/cms/homepage` and `/cms/about` with the new nodes with type `nt:simple_page`.

Add a media node with the 2 images below it, and add the policy.pdf under /cms

+ /cms
    + /media
        + /envil.gif
        + /explosive-tennisballs.jpg
    + /policy.pdf

Adjust your 'Router' to use a different 'Controller' based on the NodeType.

Show an image 'gallery' on the media page with the 2 imported images.

## Part 3

### Introduction

 - jcr:uuid
 - Using referencing to create links

### Goal

Create a menu on your site and add a new URL to an existing node (f.e. /documents/policy to policy.pdf) 

## Part 4

### Introduction

VersioningManager

### Goal

Add versioning to your app, add a dropdown to your site where you can select the history.


## Part 5 - Bonus

### Goal

Add multilanguage support

 - Add basic multilanguage support to your content
     - Can be based on properties or childnodes
     - Can be dependent on URL prefix or a simple query parameter






# TODO's

- Create fixture data + resources (image/pdf)
- Try out each step
- Create reset.sh scripts for each task


# Commands to remember

Export workspace to file:
`session:export:view /cms /vagrant/util/export-partX.xml`




