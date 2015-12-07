/* Gets event, notification, and page data */

USE SnakeCharmer;


SELECT
	e.Id AS EID, et.Type AS EType, e.SubjectAttr AS EIdentifier, e.SubjectVal AS EAttrVal,
	p.Uri AS PageUri, 'false' AS HasTriggered
FROM Event AS e

	INNER JOIN EventType AS et
		ON e.EventTypeId = et.Id

	INNER JOIN PageEvent AS pe
		ON e.Id = pe.EventId

	INNER JOIN Page AS p
		ON pe.PageId = p.Id

	INNER JOIN Account AS a
		ON e.AccId = a.Id

WHERE p.Uri = 'http://www.barnescode.com/sc.php' AND a.License = 'xkH4edko9Kl3'
;


SELECT
	a.Name AS EAction
FROM Action AS a
	INNER JOIN EventAction AS ea
		ON a.Id = ea.ActionId
WHERE ea.EventId IN (1,2,3,4);



SELECT
	n.Id AS NID, n.Title AS NTitle, n.Media AS NMedia, n.Body AS NBody,
	e.Id AS EID, 'false' AS HasSeen
FROM Notification AS n

	INNER JOIN EventNotification AS en
		ON n.Id = en.NotificationId

	INNER JOIN Event AS e
		ON en.EventId = e.Id

	INNER JOIN Account AS a
		ON e.AccId = a.Id


WHERE n.Active = 1 AND n.Del <> 1 AND a.License = 'xkH4edko9Kl3' AND e.Id IN (0,1,2,3)
