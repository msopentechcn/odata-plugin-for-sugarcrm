#!/bin/bash

# Zip up module loadable packages so they can be installed into Sugar instances

zip -r --filesync ../odata-plugin.zip * -x "*.DS_Store" -x ".git*" -x "__MAC*" -x "buildPackage.sh"