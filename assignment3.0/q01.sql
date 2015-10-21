SELECT DISTINCT fldCourseName 
FROM tblCourses 
INNER JOIN tblEnrolls on tblCourses.pmkCourseId = tblEnrolls.fnkCourseId 
WHERE tblEnrolls.fldGrade >= 100 
ORDER BY fldCourseName ASC;