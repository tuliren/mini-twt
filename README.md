Fall2013-Group4 Mini twitter server for CS506 course project
============================================

## Basic information

groupId: com.grp4.loginsystem

artifactId: LoginSystem

version: 1.0-SNAPSHOT

package: com.grp4.loginsystem

## Dependencies
Java, Maven, Spring, Hibernate, Struts2, MySQL

## Database settings

MySQL should be hosting database `loginsystem` at `locolhost:3306`.
The schema for the database can be found in the `sql` file at `\LoginSystem\databse`.

## Instructions
- modify database access settings
- `cd` into `LoginSystem`;
- generate war file by:
  `cd LoginSystem
   mvn clean
   mvn compile
   mvn war:war`
- deploy the war file by Tomcat;
- use url `localhost:8080/<war-file-name>/listAllUsers.action` for access.

## Reference
http://jmuras.com/blog/2010/spring-hibernate-maven-struts2-integration-tutorial/
