SELECT pmkPlanId, fldDateCreated, fldCatalogYear, fnkStudentId, fnkAdvisorId, pmkYear, pmkTerm, fnkCourseId
FROM tblPlan 
INNER JOIN tblSemesterPlan on pmkPlanId = tblSemesterPlan.fnkPlanId
INNER JOIN tblSemesterPlanCourses on tblSemesterPlan.fnkPlanId = tblSemesterPlanCourses.fnkPlanId 
AND pmkYear = fnkYear 
AND pmkTerm = fnkTerm
WHERE pmkPlanId = 1
ORDER BY tblSemesterPlan.fldDisplayOrder ASC, tblSemesterPlanCourses.fldDisplayOrder ASC;