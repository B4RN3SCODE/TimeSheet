USE SnakeCharmer;

/* Passed to API 1) License | 2) Theme Id */
/*
SELECT
	ne.Id AS ElmRecordId, ne.Name AS ElmName, ne.ElmId, ne.Height AS ElmH, ne.Width AS ElmW, ne.Style AS ElmStyle, ne.DisplayOrder AS ElmDO, ne.InnerHtml AS ElmInnerHtml, ne.DisplayNotifCount AS ElmShowCount,
	ns.ThemeId AS ThemeId,
	net.Type AS ElmType, net.HtmlTag AS ElmTag, net.CloseTag AS ElmUseCloseTag
FROM NotificationElm AS ne

	INNER JOIN NotificationSet AS ns
		ON ne.Id = ns.NotificationElmId

	INNER JOIN NotificationElmType AS net
		ON ne.TypeId = net.Id


	INNER JOIN Account AS a
		ON ne.AccId = a.Id


	INNER JOIN Theme AS t
		ON a.Id = t.AccId

WHERE ns.ThemeId = 1 AND a.License = 'xkH4edko9Kl3'
;
*/

/*
SELECT
	nea.NotificationElmId AS ElmRecordId, nea.Attribute AS ElmAttribute, nea.Value AS ElmAttributeValue
FROM NotificationElmAttribute AS nea
WHERE nea.NotificationElmId IN (1,2);
*/
