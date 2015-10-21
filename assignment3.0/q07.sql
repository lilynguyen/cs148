SELECT  fldFirstName, fldLastName, COUNT(fnkCourseId), AVG(fldGrade) 
FROM tblStudents  
INNER JOIN tblEnrolls ON fnkStudentId = tblStudents.pmkStudentID 
WHERE fldState = 'VT' 
AND fldGrade > (SELECT AVG(fldGrade) FROM tblEnrolls INNER JOIN tblStudents ON tblEnrolls.fnkStudentId = pmkStudentID WHERE fldState = 'VT') 
GROUP BY fnkStudentId
ORDER BY AVG(fldGrade) DESC;