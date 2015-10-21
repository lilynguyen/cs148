SELECT fldFirstName, fldphone, fldSalary 
FROM tblTeachers 
WHERE fldSalary < (SELECT avg(fldSalary) FROM tblTeachers);