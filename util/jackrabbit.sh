#!/bin/bash

JR_HOST=127.0.0.1
JR_PORT=8080
JR_DIR=/usr/local/jackrabbit
PWD_DIR=$(pwd)
PID=

function usage()
{
    echo
    echo "Usage: ./jackrabbit.sh start|stop"
    echo
}

function getPid()
{
    PID=$(ps -ef | grep jackrabbit-standalone | grep -v grep | awk '{print $2}')
}

function startServer()
{
    getPid
    if [ ! -z $PID ]; then
        echo
        echo "Jackrabbit is already running"
        echo
        exit 1
    fi

    cd $JR_DIR
    java -jar jackrabbit-standalone-2.8.0.jar &

    while [ -z "`curl -s "http://$JR_HOST:$JR_PORT"`" ] ; do sleep 1s; echo -n "."; done
    echo "Jackrabbit started"
}

function stopServer()
{
    getPid
    if [ -z $PID ]; then
        echo
        echo "Jackrabbit doesnt seem to be running"
        echo
        exit 1
    fi

    kill $PID

    while true; do
        getPid
        if [ -z $PID ]; then
            exit 0
        fi
    done

    exit 0
}

if [[ $1 == "start" ]]; then
    startServer
    exit 0
fi

if [[ $1 == "stop" ]]; then
    stopServer
    exit 0
fi

usage
exit 1
