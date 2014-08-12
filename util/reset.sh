#!/bin/bash

# Try and determine current dir
DIR="$( cd "$( dirname "$0" )" && pwd )"

PART=$1
WORKSPACES_DIR=/usr/bin/jackrabbit/jackrabbit/workspaces

function help {
    echo "Usage: $0 <part>"
    echo ""
    echo "Available parts:"
    echo "  - part1"

    exit 1
}

if [ ! -w $WORKSPACES_DIR ]; then
    echo 
    echo "You don't have enough persmissions to create/delete workspaces"
    echo "Please run this script as root"
    echo 
    exit 1
fi

function create_workspace {
    if [ -z $1 ]; then
        echo "Missing argument"
        exit 1
    fi

    mkdir -p $WORKSPACES_DIR/$1
    touch $WORKSPACES_DIR/$1/workspace.xml
    sed s/%%workspace%%/$1/ $DIR/workspace.xml > $WORKSPACES_DIR/$1/workspace.xml
}

function reset_workspace {
    if [ -z $1 ]; then
        echo "Missing argument"
        exit 1;
    fi

    echo "Removing $WORKSPACES_DIR/$1"
    rm -rf $WORKSPACES_DIR/$1

    create_workspace $1

    echo "Recreated workspace $PART1"
    echo "Restarting jackrabbit"

    /etc/init.d/jackrabbit stop
    /etc/init.d/jackrabbit start

    # Import the fixture data when available
    if [ -f "$DIR/export-$PART.xml" ]; then
        echo "Importing fixture data"
        phpcrsh -t jackrabbit --phpcr-workspace=$PART --command "session:import-xml / '$DIR/export-$PART.xml'" --command "session:save"
    fi
}

if [ -z $PART ]; then
    help
fi

if [ ! -d /vagrant ]; then
    echo "$1 should be run from within vagrant"
    exit 1
fi

read -p "Are you sure you want to reset to $PART? All current data for $PART will be deleted! [y/n]: " SURE

if [[ $SURE != "y" ]]; then
    echo "Cancelled reset"
    exit 1
fi

reset_workspace $PART
