#!/usr/bin/env ruby
##########################################
# Tasks for testing XhochY PHP Exception #
##########################################

## Tasks ##

task :xyexception_test do |t|
  sh 'phpunit AllTests xyexception-tests/all.tests.php'
end