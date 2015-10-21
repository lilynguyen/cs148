SELECT DISTINCT fldBuilding, COUNT(*) 
FROM tblSections 
GROUP BY fldBuilding;