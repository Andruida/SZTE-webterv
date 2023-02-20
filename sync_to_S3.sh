#!/bin/bash

shopt -s expand_aliases
source ~/.bash_aliases

cntb-s5cmd sync --exclude ".git/*" --delete . s3://webterv/