/*

GLOBALS

*/

//User defined globals
let SET_SLOT_HEIGHT = 80
let SET_SLOT_WIDTH = 60
let SLOT_TYPE_1 = "genre"
let SLOT_TYPE_2 = "targetGroup"
let SLOT_TYPE_3 = "designElement"
let SLOT_TYPE_4 = "learningMethod"
let SLOT_TYPE_5 = "problem"
let SLOT_CANVAS_1 = "slot1"
let SLOT_CANVAS_2 = "slot2"
let SLOT_CANVAS_3 = "slot3"
let SLOT_CANVAS_4 = "slot4"
let SLOT_CANVAS_5 = "slot5"
let SLOTCANVAS = [SLOT_CANVAS_1, SLOT_CANVAS_2, SLOT_CANVAS_3, SLOT_CANVAS_4, SLOT_CANVAS_5]
let ROLL_BUTTON = "rollButton"
let HOLD_BUTTON_1 = "holdButton1"
let HOLD_BUTTON_2 = "holdButton2"
let HOLD_BUTTON_3 = "holdButton3"
let HOLD_BUTTON_4 = "holdButton4"
let HOLD_BUTTON_5 = "holdButton5"
let INITIAL_SPEED = 15
let roll = new Audio("sound/rolling.wav")


//System defined globals
let SLOT_1
let SLOT_2
let SLOT_3
let SLOT_4
let SLOT_5
let SLOTS = [SLOT_1,SLOT_2,SLOT_3,SLOT_4,SLOT_5]
let GAME_STATE = 0
let TURN_COUNT = 0
let winnerSlots = []
let slotStates = [0,0,0,0,0]
let buttonStates = [0,0,0,0,0]
let ideaBox = ""

/*

    Loads all preloadable game elements and data

*/

window.onload = function(){

    let load_status = "Loading started"

    //Retrieve data from database
    load_status = "Retrieving data from database"
    let generateData = generateDataArray(fromDatabase)

    //Generate content for all slots
    load_status = "Generating content for slots"
    SLOT_1 = generateSlotContent(SLOT_TYPE_1, generateData, SET_SLOT_HEIGHT)
    SLOT_2 = generateSlotContent(SLOT_TYPE_2, generateData, SET_SLOT_HEIGHT)
    SLOT_3 = generateSlotContent(SLOT_TYPE_3, generateData, SET_SLOT_HEIGHT)
    SLOT_4 = generateSlotContent(SLOT_TYPE_4, generateData, SET_SLOT_HEIGHT)
    SLOT_5 = generateSlotContent(SLOT_TYPE_5, generateData, SET_SLOT_HEIGHT)
    SLOTS = [SLOT_1,SLOT_2,SLOT_3,SLOT_4,SLOT_5]

    //Draw all the slots
    load_status = "Drawing slots on canvas"
    drawSlot(SLOT_1, SLOT_CANVAS_1, SET_SLOT_WIDTH, SET_SLOT_HEIGHT)
    drawSlot(SLOT_2, SLOT_CANVAS_2, SET_SLOT_WIDTH, SET_SLOT_HEIGHT)
    drawSlot(SLOT_3, SLOT_CANVAS_3, SET_SLOT_WIDTH, SET_SLOT_HEIGHT)
    drawSlot(SLOT_4, SLOT_CANVAS_4, SET_SLOT_WIDTH, SET_SLOT_HEIGHT)
    drawSlot(SLOT_5, SLOT_CANVAS_5, SET_SLOT_WIDTH, SET_SLOT_HEIGHT)
    ideaBox = document.getElementById("ideaText")
    ideaBox.innerHTML = "Roll to find an idea!"

    load_status = "Configuring buttons"
    document.getElementById(ROLL_BUTTON).disabled = false
    document.getElementById(HOLD_BUTTON_1).disabled = true
    document.getElementById(HOLD_BUTTON_2).disabled = true
    document.getElementById(HOLD_BUTTON_3).disabled = true
    document.getElementById(HOLD_BUTTON_4).disabled = true
    document.getElementById(HOLD_BUTTON_5).disabled = true

    load_status = "Loading completed!"
    document.getElementById("loaderBody").style.display = "none" // Hides loading screen

}

/* 

    Game Controller

*/

function holdButtonToggler(holdButtonNumber){
    if(slotStates[holdButtonNumber-1] == 0){
        let buttonControl = buttonStates[0]+buttonStates[1]+buttonStates[2]+buttonStates[3]+buttonStates[4]
        if(buttonControl >= 3){
            slotStates[holdButtonNumber-1] = 0
            buttonStates[holdButtonNumber-1] = 0
            document.getElementById("lock"+holdButtonNumber).src = "img/lock_open.svg"
            document.getElementById("holdButton"+holdButtonNumber).style.backgroundColor = "#E7E7E7"

        }else{
            slotStates[holdButtonNumber-1] = 1
            buttonStates[holdButtonNumber-1] = 1
            document.getElementById("lock"+holdButtonNumber).src = "img/lock_locked.svg"
            document.getElementById("holdButton"+holdButtonNumber).style.backgroundColor = "#6bcaba"
        }
    }
    else{
        slotStates[holdButtonNumber-1] = 0
        buttonStates[holdButtonNumber-1] = 0
        document.getElementById("lock"+holdButtonNumber).src = "img/lock_open.svg"
        document.getElementById("holdButton"+holdButtonNumber).style.backgroundColor = "#E7E7E7"
    }
}

function selectWinners(){
    for(let i=0; i<5; i++){
        if(slotStates[i] == 0){
            winnerSlots[i] = (randomSlotPosition(SLOTS[i]))
            
        }
    }
}

function audio(){
	if(GAME_STATE == 1){
		roll.currentTime = 0
		roll.play()
	}
	if(GAME_STATE == 0){
		roll.pause()
	}
}

function muteAudio(){
	if(roll.muted === false){
		roll.muted = true
		document.getElementById("sound").innerHTML = "Unmute"
	} else {
		roll.muted = false
		document.getElementById("sound").innerHTML = "Mute"
	}
}

function initGame(){
    GAME_STATE = 1
    TURN_COUNT += 1
    document.getElementById("ideaText").innerHTML = "Generating..."
    document.getElementById(ROLL_BUTTON).disabled = true
    document.getElementById(HOLD_BUTTON_1).disabled = true
    document.getElementById(HOLD_BUTTON_2).disabled = true
    document.getElementById(HOLD_BUTTON_3).disabled = true
    document.getElementById(HOLD_BUTTON_4).disabled = true
    document.getElementById(HOLD_BUTTON_5).disabled = true
    let counter = 0
    let gameDone = 0
    let start_gap = 0
    if(window.innerWidth > 800){
        start_gap = 150
    }else{
        start_gap = 75
    }
    let stop_gap = 50
    let slotsClosed = 0
    let SPEED = INITIAL_SPEED
	audio()
    selectWinners()
	
    var timerloop = setInterval(function(){
        for(let i = 0; i<SLOTS.length; i++){
            if(slotStates[i] == 0){
                slotAnimation(SLOTS[i], SLOTCANVAS[i], SPEED)
            }
            else{
                slotStates[i] = 1
            }
        }

        if(counter>start_gap){
            if(slotStates[slotsClosed] == 0){
                document.getElementById(SLOTCANVAS[slotsClosed]).style.top = -winnerSlots[slotsClosed].winPos+"px"
                document.getElementById(SLOTCANVAS[slotsClosed]).style.display = "block"
                slotStates[slotsClosed] = 1
            }
            slotsClosed += 1
            start_gap = start_gap + stop_gap
            if(slotsClosed == 5){
                clearInterval(timerloop) // Loop end
                GAME_STATE = 0
				audio()
                for(let i=0; i<slotStates.length; i++){
                    if(buttonStates[i] === 1){
                        slotStates[i] = 1
                    }else{
                        slotStates[i] = 0
                    }
                }
                ideaBox.innerHTML = winnerSlots[0].sentence+" "+winnerSlots[1].sentence+" "+winnerSlots[2].sentence+" "+winnerSlots[3].sentence+" "+winnerSlots[4].sentence+"."
                document.getElementById(ROLL_BUTTON).disabled = false
                document.getElementById(HOLD_BUTTON_1).disabled = false
                document.getElementById(HOLD_BUTTON_2).disabled = false
                document.getElementById(HOLD_BUTTON_3).disabled = false
                document.getElementById(HOLD_BUTTON_4).disabled = false
                document.getElementById(HOLD_BUTTON_5).disabled = false
            }
        }
        
        counter++

    },10)
    
}


