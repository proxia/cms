/* 
	calendar-sk-utf8.js
	language: Slovak
	encoding: utf-8

*/

// ** I18N
Calendar._DN  = new Array('Nedeľa','Pondelok','Utorok','Streda','Štvrtok','Piatok','Sobota','Nedeľa');
Calendar._SDN = new Array('Ne','Po','Ut','St','Št','Pi','So','Ne');
Calendar._MN  = new Array('Január','Február','Marec','Apríl','Máj','Jún','Júl','August','September','Október','November','December');
Calendar._SMN = new Array('Jan','Feb','Mar','Apr','Máj','Jún','Júl','Aug','Sep','Okt','Nov','Dec');

// tooltips
Calendar._TT = {};
Calendar._TT["INFO"] = "O komponente kalendár";
Calendar._TT["TOGGLE"] = "Zmena prvého dňa v týždni";
Calendar._TT["PREV_YEAR"] = "Predchádzajúci rok (pridrž pre menu)";
Calendar._TT["PREV_MONTH"] = "Predchádzajúci mesiac (pridrž pre menu)";
Calendar._TT["GO_TODAY"] = "Dnešný dátum";
Calendar._TT["NEXT_MONTH"] = "Ďalší mesiac (pridrž pre menu)";
Calendar._TT["NEXT_YEAR"] = "Ďalší rok (pridrž pre menu)";
Calendar._TT["SEL_DATE"] = "Vyber dátum";
Calendar._TT["DRAG_TO_MOVE"] = "Chyť a ťahaj, pre presun";
Calendar._TT["PART_TODAY"] = " (dnes)";
Calendar._TT["MON_FIRST"] = "Ukáž ako prvé Pondelok";
//Calendar._TT["SUN_FIRST"] = "Ukaž jako první Neděli";

Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) esoft.sk \n" + // don't translate this this ;-)
"\n\n" +
"Výber dátumu:\n" +
"- Použi  \xab, \xbb tlačítka pre vybratie roku\n" +
"- Použi tlačítka " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " k výberu mesiaca\n" +
"- Podržte tlačítko myši na akomkoľvek z týchto tlačítok pre rýchlejší výber.";

Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Výber času:\n" +
"- Kliknite na akúkoľvek z časti výberu času pre zvýšenie.\n" +
"- alebo Shift-click pre zníženie\n" +
"- alebo kliknite a ťahajte pre rýchlejší výber.";

// the following is to inform that "%s" is to be the first day of week
// %s will be replaced with the day name.
Calendar._TT["DAY_FIRST"] = "Zobraz %s prvé";

// This may be locale-dependent.  It specifies the week-end days, as an array
// of comma-separated numbers.  The numbers are from 0 to 6: 0 means Sunday, 1
// means Monday, etc.
Calendar._TT["WEEKEND"] = "0,6";

Calendar._TT["CLOSE"] = "Zavrieť";
Calendar._TT["TODAY"] = "Dnes";
Calendar._TT["TIME_PART"] = "(Shift-)Klikni alebo ťahaj pre zmeny hodnoty";

// date formats
Calendar._TT["DEF_DATE_FORMAT"] = "d.m.yy";
Calendar._TT["TT_DATE_FORMAT"] = "%a, %b %e";

Calendar._TT["WK"] = "wk";
Calendar._TT["TIME"] = "Čas:";
