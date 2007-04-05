#!/usr/bin/env ruby
#######################################################
# Tasks for creating the PHP-sourcecode documentation # 
#######################################################

## Includes ##

require 'rake/clean';

## Tasks ##

task :src_doc => 'xyexception-docs/elementindex.html'

## File Tasks ##

file 'xyexception-docs/elementindex.html' => FileList['xyexception-includes/*.php'] do
  sh 'phpdoc -t xyexception-docs/ -f xyexception-includes/xyexception.exception.php'
end

## clean Task ##

CLEAN.include('xyexception-docs/*')
CLEAN.exclude('xyexception-docs/.svn')