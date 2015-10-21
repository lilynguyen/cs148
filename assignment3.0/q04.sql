SELECT DISTINCT fnkSectionId, fldFirstName, fldLastName 
FROM tblStudents 
INNER JOIN tblEnrolls on fnkStudentId = pmkStudentId 
WHERE fnkCourseID = '392' 
ORDER BY fnkSectionId ASC;