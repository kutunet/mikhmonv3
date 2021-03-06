<?php
/*
 *  Copyright (C) 2018 Laksamadi Guko.
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
session_start();
// hide all error
error_reporting(0);
if (!isset($_SESSION["mikhmon"])) {
	header("Location:../admin.php?id=login");
} else {

	$getbinding = $API->comm("/ip/hotspot/ip-binding/print");
	$TotalReg = count($getbinding);

	$countbinding = $API->comm("/ip/hotspot/ip-binding/print", array(
		"count-only" => "",
	));
}

?>
<div class="row">
<div id="reloadbinding">
<div class="col-12">
<div class="card">
<div class="card-header">
	<h3><i class=" fa fa-address-book"></i> IP Binding 
<?php
if ($countbinding < 2) {
	echo "$countbinding item";
} elseif ($countbinding > 1) {
	echo "$countbinding items";
};
echo "</th>";
?>
</strong>
    </h3>
</div>
<div class="card-body">	   
<div class="w-6">
    <input id="filterTable" type="text" class="form-control" placeholder="Search..">
  </div>
<div class="overflow box-bordered mr-t-10" style="max-height: 75vh">  	   
<table id="dataTable" class="table table-bordered table-hover text-nowrap"> 
 <thead>
  <tr>
    <th></th>
    <th></th>
    <th>Name</th>
    <th>MAC Address</th>
    <th>Address</th>
    <th>To Address</th>
    <th>Server</th>
  </tr>
  </thead>
  <tbody> 
<?php
for ($i = 0; $i < $TotalReg; $i++) {
	$binding = $getbinding[$i];
	$id = $binding['.id'];

	$maca = $binding['mac-address'];
	$addr = $binding['address'];
	$toaddr = $binding['to-address'];
	$server = $binding['server'];
	$commt = $binding['comment'];
	$bdisabled = $binding['disabled'];

	echo "<tr>";
	?>
  	<td style='text-align:center;'><i class='fa fa-minus-square text-danger pointer' onclick="if(confirm('Are you sure to delete (<?= $maca; ?>)?')){window.location='./?remove-ip-binding=<?= $id . "&mac=" . $maca . "&addr=" . $addr; ?>&session=<?= $session; ?>'}else{}" title='Remove <?= $maca; ?>'></i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
  	<?php
		echo "<a class='btnsmall' title='Remove " . $maca . "' href='./?remove-ip-binding=" . $id . "&mac=" . $maca . "&addr=" . $addr . "&session=" . $session . "'></a>";
		if ($bdisabled == "true") {
			echo "<a class='text-warning' title='Enable Binding " . $addr . "' class='btnsmall' href='./?enable-ip-binding=" . $id . "&session=" . $session . "'><i class='fa fa-lock'></a></td>";
		} else {
			echo "<a title='Disable Binding " . $addr . "' class='btnsmall' href='./?disable-ip-binding=" . $id . "&session=" . $session . "'><i class='fa fa-unlock '></a></td>";
		}
		echo "<td style='text-align:center;'>";
		if ($binding['bypassed'] == "true") {
			echo "<b style='color:#0091EA;'>P</b>";
		} else {
		}
		echo "</td>";
		echo "<td>" . $commt . "</td>";
		echo "<td>" . $maca . "</td>";
		echo "<td>" . $addr . "</td>";
		echo "<td>" . $toaddr . "</td>";
		echo "<td>" . $server . "</td>";
		echo "</tr>";
	}
	?>
  </tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
