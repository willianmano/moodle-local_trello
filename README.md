Moodle Trello Tasks
===

A local plugin to create Trello boards when a new course is created on Moodle

Lists template
---

You can add a json data as a template for your lists and tasks that you commonly use to build your courses. For  example, the code below will create three lists and the list "To do" will have 4 cards. 

```
{
     "Done":[],
     "Doing":[],
     "To do":[
         "Add teachers",
         "Configure the enrolment methods",
         "Create groups",
         "Add course syllabus"
     ]
 }
```

Developed and maintained by
---
Willian Mano
 - Zend Certified PHP Engineer - ZEND028770
 - Certified Scrum Master - 000570341
 - iMasters Certified Professional - PHP - Good Practices - 1076

Moodle profile: https://moodle.org/user/profile.php?id=968235

Linkedin: https://www.linkedin.com/in/willianmano

Installation
------------

**First way**

- Clone this repository into the folder `local`.
- Access the notification area in moodle and install

**Second way**

- Download this repository
- Extract the content
- Put the folder into the folder `local` of your moodle
- Access the notification area in moodle and install