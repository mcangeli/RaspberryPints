RaspberryPints (RPints) is a digital upgrade to the conventional chalkboard taplist, created just for the home brewer. Display your current beers on tap with a sleek, digital presentation. Manage your beers, recipes, kegs, and taps with our built-in tracking system.

/******** Information on Flow Meters ********/

The Flow Meters in use are SwissFlow SF-800's. They are connected to the RaspberryPi via the Alamode Board using pins 8,9,10 and 11 on the GIPO pins. For the meters, the middle wire is connected to the GIPO Pin, the striped wire (red or black it seems) is connected to Ground (GND) and the third wire is connected to vin.

You have to upload the Raspberrypints.ino file in the arduino folder via the arduino-ide program on your rpi. Make sure you adjust the number of pins and the pin numbers before compiling and uploading to the alamode. For more information, please see: https://github.com/RaspberryPints/RaspberryPints/issues/194

Then you run the flow_monitor.py script.

You need to have python serial and python mysqldb installed:
```
sudo apt-get install python-serial python-mysql
```

prior to running and you need to edit your database settings as well as the tap pin numbers for the correct tap.

Information on the flow meters:
```
Range
Flow velocity*:	0.5 – 20 litre per minute
Temperature:	-20 – +90 °C
Operating pressure:	16 bar
Max. pressure:	40 bar
 
Technical information SF-800
Process connections:	3/8” hose barb; 3/8”BSP Male
Exitation:	5 to 24 VDC, 12 to 24 mA
Power consumption:	12 – 36 mA/s
Material:	PVDF, Vectra (rotor), Viton or EPDM
Output:	frequency
Output frequency:	100 to 2000 Hz (depending on the flow velocity)
K-factor:	6100 pulse/liter to 5400 pulse/liter
Length cable:	15 cm standard (different length on request)
Connector electronics:	3-wire flat cable sealed in housing (jack-plug or molex connector on request)
 
Reliability
Interchangeability**:	+/- 2.25 %
Accuracy:	+/- 1.00 %
Reproducibility:	+/- 0.30 %
 
Medium
Medium type:	clear or translucent liquids that do not block infrared light
Viscosity:	1-1000 Cst
Examples:	water, chemicals, oil, beer, syrup
http://www.swissflow.com/sf800.html
```

Licensing:

	GNU GENERAL PUBLIC LICENSE
	Version 3, 29 June 2007

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

Full license text available in 'LICENSE.md'.


Questions? Comments? Want to Contribute?
http://www.homebrewtalk.com/f51/initial-release-raspberrypints-digital-taplist-solution-456809/

Inspired by Kegerface:
http://github.com/kegerface/kegerface
