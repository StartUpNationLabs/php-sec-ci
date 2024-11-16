# php-sec-ci deployment documentation

## Quick overview

- Any push that passes the CICD pipeline results in an approval request.  
  - On-premise: Approval triggers deployment on a local machine.  
  - AWS-EC2: Approval triggers deployment on an EC2 instance.  

- Each instance has its own secrets.  
- Purpose: Create two distinct environments for testing.  
- Both environments were created using a custom Ansible script.  
- Environments are iso-prod, meaning identical configuration and capabilities, except for networking.  

## CICD

- One job per environment for deployment
    - deploy-ssh-staging
    - deploy-ssh-production 

- For each deployment we do :
    - Secret fetching from infisical
    - SSH login to destination machine
    - creation of .env in the destination machine
    - run compose.yaml in destination machine

## Machine setup :

As said before, we use an ansible script that install every necessary utilities for our project.