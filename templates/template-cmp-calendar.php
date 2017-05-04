<?php

// the iCal date format. Note the Z on the end indicates a UTC timestamp.
//define('DATE_ICAL', 'Ymd\THis\Z');
define('DATE_ICAL', 'Ymd\THis');
// max line length is 75 chars. New line is \\n
$output = '
BEGIN:VCALENDAR
METHOD:PUBLISH
VERSION:2.0
PRODID:-//Cristian Marin//CSI//EN
X-WR-CALNAME:Calendario Cambios Novis
CALSCALE:GERGORIAN
PREFERRED_LANGUAGE:EN';

// loop over events
global $NOVIS_CSI_CMP_TASK;
global $NOVIS_CSI_CMP_TASK_STATUS;
global $NOVIS_CSI_SERVICE;
global $NOVIS_CSI_CUSTOMER_SYSTEM;
global $NOVIS_CSI_SAPCUSTNO;
$sql = '
	SELECT
		T00.id as task_id,
		T00.start_datetime as task_start_datetime,
		T00.end_datetime as task_end_datetime,
		T00.comments as task_comments,
		T00.creation_user_email as task_organizer_email,
		T00.ticket_no as ticket_no,
		T00.zoom_conf_id as zoom_conf_id,
		T00.last_modified_date as last_modified_date,
		T00.last_modified_time as last_modified_time,
		T01.short_name as service_short_name,
		T01.name as service_name,
		T02.sid as sid,
		T04.short_name as customer_short_name,
		T04.code as customer_code,
		T05.short_name as status_short_name
	FROM
		' . $NOVIS_CSI_CMP_TASK->tbl_name . ' as T00
		LEFT JOIN ' . $NOVIS_CSI_SERVICE->tbl_name . ' as T01
			ON T00.service_id = T01.id
		LEFT JOIN ' . $NOVIS_CSI_CUSTOMER_SYSTEM->tbl_name . ' as T02
			ON T00.customer_system_id = T02.id
		LEFT JOIN ' . $NOVIS_CSI_SAPCUSTNO->tbl_name . ' as T03
			ON T02.sapcustno = T03.sapcustno
		LEFT JOIN ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' as T04
			ON T03.customer_id = T04.id
		LEFT JOIN ' . $NOVIS_CSI_CMP_TASK_STATUS->tbl_name . ' as T05
			ON T00.status_id = T05.id
	ORDER BY
		T00.start_datetime ASC

		';
$tasks = $NOVIS_CSI_CMP_TASK->get_sql ( $sql );
foreach ($tasks as $task){
	$task_description=
		'Cliente: ' . $task['customer_short_name'] . '\n' .
		'Servicio: ' . $task['service_name'] . '\n' .
		'Sistema: ' . $task['sid'] . '\n' .
		'Status de la actividad: ' . $task['status_short_name'] . '\n' .
		'Ticket: ' . $task['ticket_no'] . '\r\n' .
		'Observaciones:\n' .
		'--------------------------\n' .
		str_replace ( "\\", "\\n", str_replace ( ";" , "\;" , str_replace ( "," , '\,' , $task['task_comments'] ) ) ) . '\n' .
		//htmlentities ( $task['task_comments'] ) . '\n' .
		'--------------------------\r\n';
	if ( $task['zoom_conf_id'] ){
		$task_description.=
		'Conferencia Zoom:\n' .
		'https://novis.zoom.us/j/' . $task['zoom_conf_id'] . '\r\n';
	}



	$output .='
BEGIN:VEVENT
UID:' . $task['task_id'] . '
DTSTART:'. date(DATE_ICAL, strtotime($task['task_start_datetime'])) . '
DTEND:' . date(DATE_ICAL, strtotime($task['task_end_datetime'])) . '
SUMMARY:' . $task['customer_code'] . ' - ' . $task['service_short_name'] . ' - ' . $task['sid'] . '
DESCRIPTION:' . $task_description . '
LOCATION:http://www.noviscorp.com
STATUS:CONFIRMED
RESOURCES:' . $task['sid'] . '
CATEGORIES:Productivo
CLASS:PRIVATE
ORGANIZER:MAILTO:' . $task['task_organizer_email'] . '
LAST-MODIFIED:' . date(DATE_ICAL, strtotime($task['last_modified_date'] . ' ' . $task['last_modified_time'])) . '
END:VEVENT';
//ATTENDEE;PARTSTAT=ACCEPTED:MAILTO:cristian.marin@noviscorp.com
}
//Status
// close calendar
$output .= '
END:VCALENDAR';
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT' ); //date in the past
header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' ); //tell it we just updated
header('Cache-Control: no-store, no-cache, must-revalidate' ); //force revaidation
header('Cache-Control: post-check=0, pre-check=0', false );
header('Pragma: no-cache' );
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: inline; filename="novis_calendar.ics"');
header("Content-Description: File Transfer");
header("Content-Transfer-Encoding: binary");
header("Content-Length: " . strlen($output));
print $output;

?>
