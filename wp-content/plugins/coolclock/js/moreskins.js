CoolClock.config.skins = {
	/*
	* SKIN ID
	* unique skin name (lowercase)
	*
	* SKIN OBJECTS
	* outerBorder		- static element, can be used to draw an outer circle or solid background (requires radius)
	* largeIndicator	- hour markers, 12 static elements devided around the clock scale
	* smallIndicator	- minute markers, 48 static elements devided around the clock scale between the hour markers
	* hourHand			- element rotating in 12 hours
	* minuteHand		- element rotating in 1 hour
	* secondHand		- element rotating in 1 minute
	* secondDecoration	- additional decoration element, rotating in 1 minute
	*
	* OBJECT PARAMETERS
	* lineWidth	- width of line drawn (default 0)
	* color		- color of line drawn (default black)
	* startAt	- starting point from center, can be negative (default 0)
	* endAt		- end point from center (default 0)
	* radius	- transform line to circle with this radius around startAt as center (endAt will be ignored)
	* fillColor	- collor to fill circle (ignored when radius not used)
	* alpha		- transparency value (default 1)
	*/

	swissrail: {
		outerBorder: { lineWidth: 2, radius: 95 },
		smallIndicator: { lineWidth: 2, startAt: 88, endAt: 92 },
		largeIndicator: { lineWidth: 4, startAt: 79, endAt: 92 },
		hourHand: { lineWidth: 8, startAt: -15, endAt: 50 },
		minuteHand: { lineWidth: 7, startAt: -15, endAt: 75 },
		secondHand: { lineWidth: 1, startAt: -20, endAt: 85, color: "red" },
		secondDecoration: { lineWidth: 1, startAt: 70, radius: 4, fillColor: "red", color: "red" }
	},

	chunkyswiss: {
		outerBorder:      { lineWidth: 4, radius: 97 },
		smallIndicator:   { lineWidth: 4, startAt: 89, endAt: 93 },
		largeIndicator:   { lineWidth: 8, startAt: 80, endAt: 93 },
		hourHand:         { lineWidth: 12, startAt: -15, endAt: 60 },
		minuteHand:       { lineWidth: 10, startAt: -15, endAt: 85 },
		secondHand:       { lineWidth: 4, startAt: -20, endAt: 85, color: "red" },
		secondDecoration: { lineWidth: 2, startAt: 70, radius: 8, fillColor: "red", color: "red" }
	},

	chunkyswissonblack: {
		outerBorder:      { lineWidth: 4, radius: 97, color: "white" },
		smallIndicator:   { lineWidth: 4, startAt: 89, endAt: 93, color: "white" },
		largeIndicator:   { lineWidth: 8, startAt: 80, endAt: 93, color: "white" },
		hourHand:         { lineWidth: 12, startAt: -15, endAt: 60, color: "white" },
		minuteHand:       { lineWidth: 10, startAt: -15, endAt: 85, color: "white" },
		secondHand:       { lineWidth: 4, startAt: -20, endAt: 85, color: "red" },
		secondDecoration: { lineWidth: 2, startAt: 70, radius: 8, fillColor: "red", color: "red" }
	},

	fancy: {
		outerBorder:      { lineWidth: 5, radius: 95, color: "green", alpha: 0.7 },
		smallIndicator:   { lineWidth: 1, startAt: 80, endAt: 93, alpha: 0.4 },
		largeIndicator:   { lineWidth: 1, startAt: 30, endAt: 93, alpha: 0.5 },
		hourHand:         { lineWidth: 8, startAt: -15, endAt: 50, color: "blue", alpha: 0.7 },
		minuteHand:       { lineWidth: 7, startAt: -15, endAt: 92, color: "red", alpha: 0.7 },
		secondHand:       { lineWidth: 10, startAt: 80, endAt: 85, color: "blue", alpha: 0.3 },
		secondDecoration: { lineWidth: 1, startAt: 30, radius: 50, fillColor: "blue", color: "red", alpha: 0.15 }
	},

	machine: {
		outerBorder:      { lineWidth: 60, radius: 55, color: "#dd6655" },
		smallIndicator:   { lineWidth: 4, startAt: 80, endAt: 95, color: "white" },
		largeIndicator:   { lineWidth: 14, startAt: 77, endAt: 92, color: "#dd6655" },
		hourHand:         { lineWidth: 18, startAt: -15, endAt: 40, color: "white" },
		minuteHand:       { lineWidth: 14, startAt: 24, endAt: 100, color: "#771100", alpha: 0.5 },
		secondHand:       { lineWidth: 3, startAt: 22, endAt: 83, color: "green", alpha: 0 },
		secondDecoration: { lineWidth: 1, startAt: 52, radius: 26, fillColor: "#ffcccc", color: "red", alpha: 0.5 }
	},

	simonbaird_com: {
		hourHand:         { lineWidth: 80, startAt: -15, endAt: 35,  color: "magenta", alpha: 0.5 },
		minuteHand:       { lineWidth: 80, startAt: -15, endAt: 65,  color: "cyan", alpha: 0.5 },
		secondDecoration: { lineWidth: 1,  startAt: 40,  radius: 40, color: "#fff", fillColor: "yellow", alpha: 0.5 }
	},

	// by bonstio, http://bonstio.net
	classic/*was gIG*/: {
		outerBorder:      { lineWidth: 185, radius: 1, color: "#E5ECF9" },
		smallIndicator:   { lineWidth: 2, startAt: 89, endAt: 94, color: "#3366CC" },
		largeIndicator:   { lineWidth: 4, startAt: 83, endAt: 94, color: "#3366CC" },
		hourHand:         { lineWidth: 5, startAt: 0, endAt: 60 },
		minuteHand:       { lineWidth: 4, startAt: 0, endAt: 80 },
		secondHand:       { lineWidth: 1, startAt: -20, endAt: 85, color: "red", alpha: .85 },
		secondDecoration: { lineWidth: 3, startAt: 0, radius: 2, fillColor: "black" }
	},

	modern/*was gIG2*/: {
		outerBorder:      { lineWidth: 185, radius: 1, color: "#E5ECF9" },
		smallIndicator:   { lineWidth: 5, startAt: 88, endAt: 94, color: "#3366CC" },
		largeIndicator:   { lineWidth: 5, startAt: 88, endAt: 94, color: "#3366CC" },
		hourHand:         { lineWidth: 8, startAt: 0, endAt: 60 },
		minuteHand:       { lineWidth: 8, startAt: 0, endAt: 80 },
		secondHand:       { lineWidth: 5, startAt: 80, endAt: 85, color: "red", alpha: .85 },
		secondDecoration: { lineWidth: 3, startAt: 0, radius: 4, fillColor: "black" }
	},

	simple/*was gIG3*/: {
		outerBorder:      { lineWidth: 185, radius: 1, color: "#E5ECF9" },
		smallIndicator:   { lineWidth: 10, startAt: 90, endAt: 94, color: "#3366CC" },
		largeIndicator:   { lineWidth: 10, startAt: 90, endAt: 94, color: "#3366CC" },
		hourHand:         { lineWidth: 8, startAt: 0, endAt: 60 },
		minuteHand:       { lineWidth: 8, startAt: 0, endAt: 80 },
		secondHand:       { lineWidth: 5, startAt: 80, endAt: 85, color: "red", alpha: .85 },
		secondDecoration: { lineWidth: 3, startAt: 0, radius: 4, fillColor: "black" }
	},

	// by securephp
	securephp: {
		outerBorder:      { lineWidth: 100, radius: 0.45, color: "#669900", alpha: 0.3 },
		smallIndicator:   { lineWidth: 2, startAt: 80, endAt: 90 , color: "green" },
		largeIndicator:   { lineWidth: 8.5, startAt: 20, endAt: 40 , color: "green", alpha: 0.4 },
		hourHand:         { lineWidth: 3, startAt: 0, endAt: 60 },
		minuteHand:       { lineWidth: 2, startAt: 0, endAt: 75 },
		secondHand:       { lineWidth: 1, startAt: -10, endAt: 80, color: "blue", alpha: 0.8 },
		secondDecoration: { lineWidth: 1, startAt: 70, radius: 4, fillColor: "blue", color: "red" }
	},

	tes2: {
		outerBorder:      { lineWidth: 4, radius: 95, alpha: 0.5 },
		smallIndicator:   { lineWidth: 1, startAt: 10, endAt: 50 , color: "#66CCFF" },
		largeIndicator:   { lineWidth: 8.5, startAt: 60, endAt: 70, color: "#6699FF" },
		hourHand:         { lineWidth: 5, startAt: -15, endAt: 60, alpha: 0.7 },
		minuteHand:       { lineWidth: 3, startAt: -25, endAt: 75, alpha: 0.7 },
		secondHand:       { lineWidth: 1.5, startAt: -20, endAt: 88, color: "red" },
		secondDecoration: { lineWidth: 1, startAt: 20, radius: 4, fillColor: "blue", color: "red" }
	},

	lev: {
		outerBorder:      { lineWidth: 10, radius: 95, color: "#CCFF33", alpha: 0.65 },
		smallIndicator:   { lineWidth: 5, startAt: 84, endAt: 90, color: "#996600" },
		largeIndicator:   { lineWidth: 40, startAt: 25, endAt: 95, color: "#336600", alpha: 0.55 },
		hourHand:         { lineWidth: 4, startAt: 0, endAt: 65, alpha: 0.9 },
		minuteHand:       { lineWidth: 3, startAt: 0, endAt: 80, alpha: 0.85 },
		secondHand:       { lineWidth: 1, startAt: 0, endAt: 85 },
		secondDecoration: { lineWidth: 2, startAt: 5, radius: 10, fillColor: "black" }
	},

	sand: {
		outerBorder:      { lineWidth: 1, radius: 70, alpha: 0.5 },
		smallIndicator:   { lineWidth: 3, startAt: 50, endAt: 70, color: "#0066FF", alpha: 0.5 },
		largeIndicator:   { lineWidth: 200, startAt: 80, endAt: 95, color: "#996600", alpha: 0.75 },
		hourHand:         { lineWidth: 4, startAt: 0, endAt: 65, alpha: 0.9 },
		minuteHand:       { lineWidth: 3, startAt: 0, endAt: 80, alpha: 0.85 },
		secondHand:       { lineWidth: 1, startAt: 0, endAt: 85 },
		secondDecoration: { lineWidth: 2, startAt: 5, radius: 10, fillColor: "black" }
	},

	sun: {
		outerBorder:      { lineWidth: 100, radius: 140, color: "#99FFFF", alpha: 0.2 },
		smallIndicator:   { lineWidth: 300, startAt: 50, endAt: 70, alpha: 0.1 },
		largeIndicator:   { lineWidth: 5, startAt: 80, endAt: 95, alpha: 0.65 },
		hourHand:         { lineWidth: 4, startAt: 0, endAt: 65, alpha: 0.9 },
		minuteHand:       { lineWidth: 3, startAt: 0, endAt: 80, alpha: 0.85 },
		secondHand:       { lineWidth: 1, startAt: 0, endAt: 90 },
		secondDecoration: { lineWidth: 2, startAt: 5, radius: 10, fillColor: "black" }
	},

	tor: {
		outerBorder:      { lineWidth: 10, radius: 88, color: "#996600", alpha: 0.9 },
		smallIndicator:   { lineWidth: 6, startAt: -10, endAt: 73, color: "green", alpha: 0.3 },
		largeIndicator:   { lineWidth: 6, startAt: 73, endAt: 100, alpha: 0.65 },
		hourHand:         { lineWidth: 4, startAt: 0, endAt: 65 },
		minuteHand:       { lineWidth: 3, startAt: 0, endAt: 80 },
		secondHand:       { lineWidth: 1, startAt: -73, endAt: 73, alpha: 0.8 },
		secondDecoration: { lineWidth: 2, startAt: 5, radius: 10, fillColor: "black" }
	},

	cold: {
		outerBorder:      { lineWidth: 15, radius: 90, alpha: 0.3 },
		smallIndicator:   { lineWidth: 15, startAt: -10, endAt: 95, color: "blue", alpha: 0.1 },
		largeIndicator:   { lineWidth: 3, startAt: 80, endAt: 95, color: "blue", alpha: 0.65 },
		hourHand:         { lineWidth: 4, startAt: 0, endAt: 65 },
		minuteHand:       { lineWidth: 3, startAt: 0, endAt: 80 },
		secondHand:       { lineWidth: 1, startAt: 0, endAt: 85, alpha: 0.8 },
		secondDecoration: { lineWidth: 5, startAt: 30, radius: 10, fillColor: "black" }
	},

	babosa: {
		outerBorder:      { lineWidth: 100, radius: 25, color: "blue", alpha: 0.25 },
		smallIndicator:   { lineWidth: 3, startAt: 90, endAt: 95, color: "#3366CC" },
		largeIndicator:   { lineWidth: 4, startAt: 75, endAt: 95, color: "#3366CC" },
		hourHand:         { lineWidth: 4, startAt: 0, endAt: 60 },
		minuteHand:       { lineWidth: 3, startAt: 0, endAt: 85 },
		secondHand:       { lineWidth: 12, startAt: 75, endAt: 90, color: "red", alpha: 0.8 },
		secondDecoration: { lineWidth: 3, startAt: 0, radius: 4, fillColor: "black" }
	},

	tumb: {
		outerBorder:      { lineWidth: 105, radius: 5, color: "green", alpha: 0.4 },
		smallIndicator:   { lineWidth: 1, startAt: 93, endAt: 98, color: "green" },
		largeIndicator:   { lineWidth: 50, startAt: 0, endAt: 89, color: "red", alpha: 0.14 },
		hourHand:         { lineWidth: 4, startAt: 0, endAt: 65 },
		minuteHand:       { lineWidth: 3, startAt: 0, endAt: 80 },
		secondHand:       { lineWidth: 1, startAt: 0, endAt: 85, alpha: 0.8 },
		secondDecoration: { lineWidth: 5, startAt: 50, radius: 90, fillColor: "black", alpha: 0.05 }
	},

	stone: {
		outerBorder:      { lineWidth: 15, radius: 80, color: "#339933", alpha: 0.5 },
		smallIndicator:   { lineWidth: 2, startAt: 70, endAt: 90, color: "#FF3300", alpha: 0.7 },
		largeIndicator:   { lineWidth: 15, startAt: 0, endAt: 29, color: "#FF6600", alpha: 0.3 },
		hourHand:         { lineWidth: 4, startAt: 0, endAt: 65 },
		minuteHand:       { lineWidth: 3, startAt: 0, endAt: 75 },
		secondHand:       { lineWidth: 1, startAt: 0, endAt: 85, alpha: 0.8 },
		secondDecoration: { lineWidth: 5, startAt: 50, radius: 90, fillColor: "black", alpha: 0.05 }
	},

	disc: {
		outerBorder:      { lineWidth: 105, radius: 1, color: "#666600", alpha: 0.2 },
		smallIndicator:   { lineWidth: 1, startAt: 58, endAt: 95, color: "#669900", alpha: 0.8 },
		largeIndicator:   { lineWidth: 6, startAt: 25, endAt: 35, color: "#666600" },
		hourHand:         { lineWidth: 4, startAt: 0, endAt: 65 },
		minuteHand:       { lineWidth: 3, startAt: 0, endAt: 75 },
		secondHand:       { lineWidth: 1, startAt: -75, endAt: 75, color: "#99CC00", alpha: 0.8 },
		secondDecoration: { lineWidth: 5, startAt: 50, radius: 90, fillColor: "#00FF00", color: "green", alpha: 0.05 }
	},

	// By Yoo Nhe
	watermelon: {
		outerBorder:      { lineWidth: 100, radius: 1.7, color: "#d93d04", alpha: .75 },
		smallIndicator:   { lineWidth: 2, startAt: 50, endAt: 70, color: "#d93d04", alpha: .75 },
		largeIndicator:   { lineWidth: 2, startAt: 45, endAt: 94, color: "#a9bf04" },
		hourHand:         { lineWidth: 5, startAt: -20, endAt: 65, color: "#d93d04" },
		minuteHand:       { lineWidth: 3, startAt: -20, endAt: 80, color: "#a9bf04", alpha: .9 },
		secondHand:       { lineWidth: 2, startAt: 70, endAt: 94, color: "#d93d04", alpha: .75 },
		secondDecoration: { lineWidth: 1, startAt: 70, radius: 3, fillColor: "#d93d04", color: "#d93d04", alpha: .75 }
	},

	// By MrCarlLister
	mister: {
		largeIndicator:   { lineWidth: 10, radius:5,  startAt: 78, endAt: 98, color: "#76777b" },
		hourHand:         { lineWidth: 7, startAt: 10, endAt: 47, color: "#76777b" },
		minuteHand:       { lineWidth: 5, startAt:10, endAt: 65, color: "#76777b" },
		secondHand:       { lineWidth: 3, startAt: 0, endAt: 92, color: "#76777b" }
	}
};
