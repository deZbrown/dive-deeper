#!/bin/bash

while IFS= read -r line
do
  if [[ ! "$line" =~ ^# && -n "$line" ]]; then
    key=$(echo "$line" | cut -d '=' -f 1)
    value=$(echo "$line" | cut -d '=' -f 2)
    flyctl secrets set "$key=$value"
  fi
done < .env
