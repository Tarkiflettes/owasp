<?php

require 'class.iCalReader.php';

// Cette page reçoit une date, et une promo via une requête POST. Elle renvoie les évènements ayant été modifiés depuis cette date. Si il n'y a pas de champs date, l'intégralité de l'edt est envoyé
$dateModifMobile = htmlspecialchars($_GET['date']);
$promo = htmlspecialchars($_GET['promo']);

$urls = [
	"1A_LAVAL" => 'http://79.137.87.179:443/lespagesdelepplimobilebiencaches/EDT-1AL.ics',
	"2A_LAVAL" => 'http://79.137.87.179:443/lespagesdelepplimobilebiencaches/EDT-2AL.ics',
	"3A_LAVAL" => 'http://79.137.87.179:443/lespagesdelepplimobilebiencaches/EDT-3AL.ics',
	"4A_LAVAL" => 'http://79.137.87.179:443/lespagesdelepplimobilebiencaches/EDT-4AL.ics',
	"3A_CFA_LAVAL" => 'http://79.137.87.179:443/lespagesdelepplimobilebiencaches/EDT-3ACFAL.ics',
	"4A_CFA_LAVAL" => 'http://79.137.87.179:443/lespagesdelepplimobilebiencaches/EDT-4ACFAL.ics',
	"1A_PARIS" => 'http://79.137.87.179:443/lespagesdelepplimobilebiencaches/EDT-1AP.ics',
	"2A_PARIS" => 'http://79.137.87.179:443/lespagesdelepplimobilebiencaches/EDT-2AP.ics',
	"3A_PARIS" => 'http://79.137.87.179:443/lespagesdelepplimobilebiencaches/EDT-3AP.ics',
	"4A_PARIS" => 'http://79.137.87.179:443/lespagesdelepplimobilebiencaches/EDT-4AP.ics',
	"3A_CFA_PARIS" => 'http://79.137.87.179:443/lespagesdelepplimobilebiencaches/EDT-3ACFAP.ics',
	"4A_CFA_PARIS" => 'http://79.137.87.179:443/lespagesdelepplimobilebiencaches/EDT-4ACFAP.ics',
	"5A_LAVAL" => 'http://79.137.87.179:443/lespagesdelepplimobilebiencaches/EDT-5AL.ics',
	"5A_PARIS" => 'http://79.137.87.179:443/lespagesdelepplimobilebiencaches/EDT-5AP.ics',
];

$ical = new ical($urls[$promo]);

$newEvents = [];


foreach($ical->events() as $event){
   $dateModifEvent = substr($event["LAST-MODIFIED"], 0,8);

   if($dateModifMobile <= $dateModifEvent){
	   unset($event["CATEGORIES"]);
	   unset($event["DTSTAMP"]);
	   unset($event["SUMMARY;LANGUAGE=fr"]);
	   //unset($event["LAST-MODIFIED"]);
	   $newEvents[] = $event;
   }
}

echo '{"ical":';
echo json_encode($newEvents);
echo ',"success":1}';
