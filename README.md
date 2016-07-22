CakePHP Plugin for Morris JS Graphs
===================================

This is an attempt to build a CakePHP plugin to interface with the Morris Charts Javascript API.
I welcome any assistance for enhancing / fixing issues with this plugin!

Requirements
------------

* CakePHP 2.0+
* PHP 5.3+



Installation
------------

 
1.	Clone this repository or download a copy to the CakePHP or your application's `Plugins` directory. Be sure to name the folder `MorrisCharts`.

2.	Be sure that: you load plugins in your application's bootstrap file:

~~~php
CakePlugin::loadAll();
~~~


3. 	add the helper to your AppControler.php

~~~php
public $helpers = array('MorrisCharts.MorrisCharts');
~~~

4.	In defaut Layout copy this line in header to load script

~~~php
echo $this->MorrisCharts->scriptDefaultLayout();
~~~


5.	in your dataController send your data to your controller in this model

~~~php
array{
	array{ serie1.date1 , 	serie1.date2 , 	serie1.date3 ,	etc.. },
	array{ serie1.pt1 , 	serie1.pt1 , 	serie1.pt3 , 	etc.. },
	array{ serie2.pt2 , 	serie2.pt2 , 	serie2.pt3 , 	etc.. }, 
	etc... 
}
~~~

notes: 

* `serie.date` should be a `Date` formated in a string (or a `DateTime` formated in a String) in this format YYYY-MM-DD
* `serie.pt1` should be a `float` or a `integer`

6.	in your view you just have to insert the chart in a div

~~~php
<div id="lineGraph"></div>

<?= $this->MorrisCharts->createJsChart( 
	$list_categories , 
	$data , 
	array(
		'targetDiv' => 'lineGraph' ,
		'type'		=>	'Line' 
	)
); ?>
~~~

notes: here the details of paramaters

* the first is about labels on x axes
* the second is data
* the third is options. it's an array which can specify many things like:
  * `targetDiv` to specify the div for the chart (default to `graph`)
  * `type` to make different type charts. It can be `Line`, `Bar` or `Area` (default to `Line`)
  * `resize` to resize auto on screen (default to `true`)
  * `hideHover` to hide auto labels when you hover on the graph


Licence
-------

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program.  If not, see <http://www.gnu.org/licenses/>.
