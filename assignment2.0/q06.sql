SELECT fldCourseName 
FROM tblCourses 
WHERE fldCourseName 
LIKE '%data%' 
AND fldDepartment 
NOT LIKE 'CS';