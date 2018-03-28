<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Ludovic Boussion - Sign translator</title>
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/ml.css" />
    <link rel="stylesheet" href="./css/lity.min.css" />
    <script src="./js/p5.min.js"></script>
    <script src="./js/p5.dom.min.js"></script>
    <script src="./js/p5ml.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="./js/lity.min.js"></script>
  </head>

  <body>
    <section id="prototype">
      <div class="head"><img src="./img/Logo_fdBlanc.gif" alt="Sign translator"/></div>

      <div class="center-container row">
        <div class="input-container col-3">
          <button id="activatecam" onclick="activateCam()">Click here to activate your webcam</button>
          <div id="canvasContainer" class="right-container"></div>
        </div>
        <div class="output-container col-3">
          <div class="center-container"><h2 id="output">Need calibration</h2></div>
        </div>
      </div>

      <h2>Calibration tool</h2>

      <div class="center-container row">
        <?php
        $NUM_CLASSES=4;
        $alphabet=array('NO','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        for ($i=0; $i < $NUM_CLASSES; $i++){ 
        ?>
        <div class="letters-container">
          <div class="confidence-box">
            <div class="progress" id="progress<?php echo $i; ?>">
              <img src="./img/letters-480/<?php echo $alphabet[$i]; ?>.png" width="100px" height="100px" alt=""/>
              <div class="progress-bar" id="progress-bar<?php echo $alphabet[$i]; ?>"></div>
            </div>
          </div>

          <div class="exampereset-container">
            <span id="example<?php echo $alphabet[$i]; ?>">0 ex.</span> - <button id="reset<?php echo $alphabet[$i]; ?>">Reset</button>
          </div>
          
          <div class="trainbtn-box">
            <button id="button<?php echo $alphabet[$i]; ?>" class="train-button"><?php if ($alphabet[$i]=="NO"){echo "No sign";}else{echo $alphabet[$i];} ?></button>
          </div>
        </div>
        <?php } ?>
      </div>
    </section>

<h2>— How does it work?</h2>
    <p>I tried to keep that prototype as simple as possible. If the instructions below aren't clear, here is a <a href="//www.youtube.com/watch?v=vFxb0oZRKyc" data-lity>few seconds video that will make it easier</a>. <b>Also, that prototype is optimized for Google Chrome and a computer. Not for smartphone, yet.</b></p>
    <ol>
      <li><b>Activate the webcam</b><br />
        To activate the webcam, click on the big square "Click here to activate your webcam". You should have a notification from your browser that is asking you if you want to allow your webcam for that website. Click on "Allow". You should now see what your webcam is seeing instead of the black square.
      </li><br />
      <li><b>Calibration</b><br />
        The second step is also really easy.<br />
        - First calibrate without any sign on the webcam. Hold the button "No sign" few seconds.<br />
        - Then do the sign for A in front of the webcam, and hold the button "A" few seconds.<br />
        - Then do the sign for B in front of the webcam, and hold the button "B" few seconds.<br />
        - Then do the sign for C in front of the webcam, and hold the button "C" few seconds.<br />
        Well done! You made it. Now if you do a sign infront of your webcam, it should recognize the sign and display the right letter in the blue square.
      </li><br />
      <li><b>It doesn't recognize well the sign?</b><br />          
        It's not a problem. Do the sign that isn't well recognized and hold the button of the sign again few seconds. You can repeat that action until you have a well recognition of every letters. 
      </li>
    </ol><br /><br />

    <section id="me"><span>Ludovic Boussion</span> — 4 Feb 2018</section><br />

    <script src="sketch.js"></script>
  </body>
</html>