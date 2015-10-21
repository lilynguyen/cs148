SELECT fldFirstName, fldLastName, SUM(fldNumStudents), fldSalary, fldSalary/SUM(fldNumStudents) 
    FROM tblTeachers 
    INNER JOIN tblSections on fnkTeacherNetId = pmkNetId 
    INNER JOIN tblCourses on pmkCourseId = fnkCourseId 
    WHERE fldDepartment = 'CS' 
    AND fldType != 'LAB' 
    AND fldNumStudents > 0 
    GROUP BY pmkNetId 
    ORDER BY fldSalary/SUM(fldNumStudents) ASC;