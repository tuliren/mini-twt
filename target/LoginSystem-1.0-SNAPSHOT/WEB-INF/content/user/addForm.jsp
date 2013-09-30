<%@ taglib prefix="s" uri="/struts-tags"%>
 
<html>
<head>
<title>Add User</title>
</head>
<body>
 
<p>Add User</p>
 
<s:form name="addForm" method="post" action="addUser.action">
 
	<s:textfield name="username" label="User" />
	<s:password name="password" label="Password" />
 
	<s:submit type="button" name="Add" />
 
</s:form>
 
</body>
</html>