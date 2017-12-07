<?php 


// Téléchargement des emploi du temps de laval
$calendrier1AL = file_get_contents("https://edt.esiea.fr/Telechargements/ical/EdT_ESIEA_1A___L2017.ics?version=2017.0.3.4&idICal=EE6C74D36733D1DA7D57850EA826F049&param=643d5b312e2e36325d2666683d3126663d3131303030");
$calendrier2AL = file_get_contents("https://edt.esiea.fr/Telechargements/ical/EdT_ESIEA_2A___L2017.ics?version=2017.0.3.4&idICal=E4DA15AE836DA37AA27FC4C368055784&param=643d5b312e2e36325d2666683d3126663d3131303030");
$calendrier3AL = file_get_contents("https://edt.esiea.fr/Telechargements/ical/EdT_ESIEA_3A___L2017.ics?version=2017.0.3.4&idICal=624C027621582D47551DA829A71E719B&param=643d5b312e2e36325d2666683d3126663d3131303030");
$calendrier3ACFAL = file_get_contents("https://edt.esiea.fr/Telechargements/ical/EdT_ESUFA_3A___W2017.ics?version=2017.0.3.4&idICal=90849319942DCA11778E850A70C058E1&param=643d5b312e2e36325d2666683d3126663d3131303030");
$calendrier4AL = file_get_contents("https://edt.esiea.fr/Telechargements/ical/EdT_ESIEA_4A___L2017.ics?version=2017.0.3.4&idICal=B2093035107064F4E61A23A262E2F755&param=643d5b312e2e36325d2666683d3126663d3131303030");
$calendrier4ACFAL = file_get_contents("https://edt.esiea.fr/Telechargements/ical/EdT_ESUFA_4A___W2017.ics?version=2017.0.3.4&idICal=B5691D4F153EED02647171B616BBCD42&param=643d5b312e2e36325d2666683d3126663d3131303030");
$calendrier5AL = file_get_contents("https://edt.esiea.fr/Telechargements/ical/EdT_ESIEA_5A___L2017.ics?version=2017.0.3.4&idICal=624C027621582D47551DA829A71E719B&param=643d5b312e2e36325d2666683d3126663d3131303030");


// Téléchargement des emploi du temps de paris
$calendrier1AP = file_get_contents("https://edt.esiea.fr/Telechargements/ical/EdT_ESIEA_1A___P2017.ics?version=2017.0.3.4&idICal=B8F1D9B3B139BC2B832B7C6D511AD4BC&param=643d5b312e2e36325d2666683d3126663d3131303030");
$calendrier2AP = file_get_contents("https://edt.esiea.fr/Telechargements/ical/EdT_ESIEA_2A___P2017.ics?version=2017.0.3.4&idICal=A96A918AEA938242D57C466E093F4D69&param=643d5b312e2e36325d2666683d3126663d3131303030");
$calendrier3AP = file_get_contents("https://edt.esiea.fr/Telechargements/ical/EdT_ESIEA_3A___P2017.ics?version=2017.0.3.4&idICal=71D8D3C2FD0614E1CC789184365DAE9F&param=643d5b312e2e36325d2666683d3126663d3131303030");
$calendrier3ACFAP = file_get_contents("https://edt.esiea.fr/Telechargements/ical/EdT_ESUFA_3A___U2017.ics?version=2017.0.3.4&idICal=CCAF3778723EB45FEC492D5CC51D2C16&param=643d5b312e2e36325d2666683d3126663d3131303030");
$calendrier4AP = file_get_contents("https://edt.esiea.fr/Telechargements/ical/EdT_ESIEA_4A___P2017.ics?version=2017.0.3.4&idICal=E96FCD4CD94E892805ED0716416FC4BC&param=643d5b312e2e36325d2666683d3126663d3131303030");
$calendrier4ACFAP = file_get_contents("https://edt.esiea.fr/Telechargements/ical/EdT_ESUFA_4A___U2017.ics?version=2017.0.3.4&idICal=688F971AE5D246CF54EDEEA570E3A6A0&param=643d5b312e2e36325d2666683d3126663d3131303030");
$calendrier5AP = file_get_contents("https://edt.esiea.fr/Telechargements/ical/EdT_ESIEA_5A___P2017.ics?version=2017.0.3.4&idICal=AE8BFF3E32DF7E74DDD1CE30A5E6C74A&param=643d5b312e2e36325d2666683d3126663d3131303030");
$calendrier5ACFAP = file_get_contents("https://edt.esiea.fr/Telechargements/ical/EdT_ESUFA_5A___U2017.ics?version=2017.0.3.4&idICal=A8C871A29F342F5606C9567287F1A1D2&param=643d5b312e2e36325d2666683d3126663d3131303030");


// Enregistrement des EDT
file_put_contents("EDT-1AL.ics", $calendrier1AL);
file_put_contents("EDT-2AL.ics", $calendrier2AL);
file_put_contents("EDT-3AL.ics", $calendrier3AL);
file_put_contents("EDT-3ACFAL.ics", $calendrier3ACFAL);
file_put_contents("EDT-4AL.ics", $calendrier4AL);
file_put_contents("EDT-4ACFAL.ics", $calendrier4ACFAL);
file_put_contents("EDT-5AL.ics", $calendrier5AL);

file_put_contents("EDT-1AP.ics", $calendrier1AP);
file_put_contents("EDT-2AP.ics", $calendrier2AP);
file_put_contents("EDT-3AP.ics", $calendrier3AP);
file_put_contents("EDT-3ACFAP.ics", $calendrier3ACFAP);
file_put_contents("EDT-4AP.ics", $calendrier4AP);
file_put_contents("EDT-4ACFAP.ics", $calendrier4ACFAP);
file_put_contents("EDT-5AP.ics", $calendrier5AP);
file_put_contents("EDT-5ACFAP.ics", $calendrier5ACFAP);
