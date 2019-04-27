#!/usr/bin/env bash

# Sets WordPress file permissions for a secure environment
#heroku config:set AWS_S3_URL=AWS_S3_URL=s3://AKIAWRQQZFSCPQ3QHHMH:SJhwngPmq6CEqbrjONPpgEXd9vDQKyghlVsyTdrM@s3-us-east-1.amazonaws.com/engineer-sorth
# - create folders
mkdir -p $HOME/web/app/uploads

# - deny write on everything
chmod -R a-w $HOME/web

# - allow write to web/app/uploads
chmod -R u+w $HOME/web/app/uploads
