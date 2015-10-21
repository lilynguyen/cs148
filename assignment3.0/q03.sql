SELECT DISTINCT fldCourseName, fldDays, fldStart, fldStop 
FROM tblSections 
INNER JOIN tblCourses on pmkCourseId = tblSections.fnkCourseId 
INNER JOIN tblTeachers on fnkTeacherNetId = pmkNetId
WHERE fnkTeacherNetId = 'jlhorton'
ORDER BY fldStart;