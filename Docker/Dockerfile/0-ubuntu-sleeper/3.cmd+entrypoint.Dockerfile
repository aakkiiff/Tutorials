FROM ubuntu

ENTRYPOINT [ "sleep" ]

#this will be the default value if u dont pass any parameter in the command line
CMD [ "5" ]