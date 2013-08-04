<?php

/*
 * Copyright (C) 2013 Hochschule RheinMain
*
* Created by: Soeren Kroell <kroell@idseven.info>

* -- Alfresco Query --
*
* This PHP Script provides a Alfresco Query Search Page
* which shows all hits of documents with the tag 'protokolle'.
*
* These documents are saved inside the Records Management > documentLibrary
* > Öffentliches > Protokolle. As soon as a new file will be insert in this
* folder it will be tagged by a Alfresco Rules, provided inside the Alfresco Share.
* After tagging the by Alfresco the file will display as an search hit.
*
*/

if (isset($_SERVER["ALF_AVAILABLE"]) == false)
{
	require_once "../Alfresco/Service/Repository.php";
	require_once "../Alfresco/Service/Session.php";
	require_once "../Alfresco/Service/SpacesStore.php";
	require_once "../Alfresco/Service/Node.php";
}

// Load login values
require_once "config.php";

// Set variables
$param = "protokolle";
$download_pre = "http://172.26.90.82:8080/share/page/document-details?nodeRef=workspace://SpacesStore/";
$prefRMA = '{http://www.alfresco.org/model/recordsmanagement/1.0}';

// Authenticate the user and create a session
$repository = new Repository($repositoryUrl);
$ticket = $repository->authenticate($userName, $password);
$session = $repository->createSession($ticket);

// Create a reference to the 'SpacesStore'
$spacesStore = new SpacesStore($session);

// Do search by tag $param
$query = 'PATH:"cm:taggable/cm:'.$param.'/member"';
$nodes = $session->query($spacesStore, $query);

// Function to format dates
function buildDate($parts){
	if ($parts != null){
		$ex = explode("-", $parts);
		$day = explode("T",$ex[2]);
		$hours = explode(":",$day[1]);

		return $day[0].'.'.$ex[1].'.'.$ex[0].', '.$hours[0].':'.$hours[1].' Uhr';
	}
}
?>

<html>
	<head>
		<title>Alfresco Prokotollsuche</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<link rel="stylesheet" type="text/css" href="../View/css/style.css">
		<link href='http://fonts.googleapis.com/css?family=Roboto:300,100'
			rel='stylesheet' type='text/css'>
		
		<script type="text/javascript" src="../View/js/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="../View/js/script.js"></script>
		
		<script type="text/javascript">
			window.onload = setupRefresh;
			
			function setupRefresh() {
			 	setTimeout("refreshPage();", 15000);
			}
			function refreshPage() {
			  	window.location = location.href;
			}
		</script>
	
	</head>

	<body>
		<div id="iDContainer">
			<div id="iDContent">
				<h1>
					Suche im Alfresco Repository nach dem Stichwort "
					<?php echo $param; ?>
					"
				</h1>
	
				<table id="sortable" class="shadow paginated">
					<thead>
						<tr>
							<th>Datainame</th>
							<th>Titel</th>
							<th>Beschreibung</th>
							<th>Autor</th>
							<th>Ersteller</th>
							<th>Erstellt</th>
							<th>Ver&ouml;ffentlicht</th>
						</tr>
					</thead>
					<?php
					foreach ($nodes as $node){
						$nodeProps = $node->getProperties();	
						?>
						<tr>
							<td><a href="<?php echo $download_pre.$node->id; ?>" title="<?php echo $node->cm_name;?>"><?php echo $node->cm_name; ?></a></td>
							<td><?php echo $node->cm_title; ?></td>
							<td><?php echo $node->cm_description; ?></td>
							<td><?php echo $node->cm_author; ?></td>
							<td><?php echo $node->cm_creator; ?></td>
							<td><?php echo buildDate($node->cm_created);?></td>
							<td><?php echo buildDate($nodeProps[$prefRMA.'publicationDate']); ?></td>
		
						</tr>
						<?php
						}
					?>
				</table>
				
				<br /> <br />
				
				<div id="tools">
					<a id="down" href="#">&lt; </a> 
					<span id="msg"></span><a id="up" href="#"> &gt;</a>
				</div>
				
			</div>
	
		</div>
	</body>
	
</html>
