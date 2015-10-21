SELECT DISTINCT fldDays, fldStart, fldStop 
FROM tblSections  
INNER JOIN tblTeachers on tblSections.fnkTeacherNetId = tblTeachers.pmkNetId 
WHERE tblTeachers.fldLastName = "Snapp" 
ORDER BY fldStart ASC;