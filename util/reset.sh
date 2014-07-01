#!/bin/bash

# Try and determine current dir
DIR="$( cd "$( dirname "$0" )" && pwd )"

PART=$1
WORKSPACES_DIR=/usr/local/jackrabbit/jackrabbit/workspaces

function help {
    echo "Usage: $0 <part>"
    echo ""
    echo "Available parts:"
    echo "  - part1"

    exit 1
}

if [ ! -d $WORKSPACES_DIR ]; then
    mkdir -p $WORKSPACES_DIR
fi

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

    $DIR/jackrabbit.sh stop
    $DIR/jackrabbit.sh start

    # Import custom stuff per part
    case $1 in
        part3)
            phpcrsh -t jackrabbit --phpcr-workspace=$PART --command "node-type:load --update $DIR/simple_page.cnd" --command "session:save"
            ;;
    esac

    # Import the fixture data when available
    if [ -f "$DIR/export-$PART.xml" ]; then
        echo "Importing fixture data"
        phpcrsh -t jackrabbit --phpcr-workspace=$PART --command "session:import-xml / '$DIR/export-$PART.xml'" --command "session:save"
    fi
}

if [ -z $PART ]; then
    help
fi

if [ ! -d /home/ezsc/www ]; then
    echo "$1 should be run from within virtualbox"
    exit 1
fi

read -p "Are you sure you want to reset to $PART? All current data for $PART will be deleted! [y/n]: " SURE

if [[ $SURE != "y" ]]; then
    echo "Cancelled reset"
    exit 1
fi

reset_workspace $PART
