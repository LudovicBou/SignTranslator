/*
===
Sign language translator - Prototype No2 
Inspired by the "Simple Teachable Machine (gif output)"

Feb 2018
===
*/

const NUM_CLASSES = 4;
let knn;
let video;
let isPredicting = false;
let prevIsPredicting = false;
let exampleCounts = new Array(NUM_CLASSES).fill(0);
let timers = new Array(NUM_CLASSES);

let predictimer;
let outputSrc;

let msgArray = ['NO','A','B','C'];

var validCam=0;

function preload() {
  // Initialize the KNN method.
  knn = new p5ml.KNNImageClassifier(modelLoaded, NUM_CLASSES, 1);
}

function setup() {
  createCanvas(320, 240).parent('canvasContainer');
  background(0);

  resetSetup();

  // Train buttons
  msgArray.forEach((id, index) => {
    let button = select('#button' + id);
    button.mousePressed(() => {
      if (timers[index]) clearInterval(timers[index]);
      timers[index] = setInterval(() => { train(index); }, 100);
    });

    button.mouseReleased(() => {
      if (timers[index]) {
        clearInterval(timers[index]);
        updateExampleCounts();
      }
    });
  });

  // Reset buttons
  msgArray.forEach((id, index) => {
    let button = select('#reset' + id);
    button.mousePressed(() => {
      clearClass(index);
      updateExampleCounts();
    });
  });
}

function draw() {
  resetDraw();
}

function resetSetup() {
  if (validCam === 1) {
    video = createCapture(VIDEO);
    video.size(227, 227);
    video.hide();
  }
}

function resetDraw() {
  if (validCam === 1) {
    background(0);
    push(); // flip video direction so it works like a mirror
      translate(width, 0);
      scale(-1, 1);
      image(video, 0, 0, width, height);
    pop();  
  }
}

// A function to be called when the model has been loaded
function modelLoaded() {
  // select('#loading').html('Model loaded!');
}

// Train the Classifier on a frame from the video.
function train(category) {
  knn.addImage(video.elt, category);
  console.log(knn);
}

// Predict the current frame.
function predict() {
  knn.predict(video.elt, gotResults);
}

// Show the results
function gotResults(results) {
  if (results.classIndex < 0) return;
  updateConfidence(results.confidences);
  updateTranslation(results);
  if (isPredicting) predictimer = setTimeout(() => predict(), 50);
}

function updateConfidence(confidences) {
  for (let j = 0; j < msgArray.length; j++) {
    //select('#progress-text' + msgArray[j]).html( confidences[j] * 100 + ' %');
    select('#progress-bar' + msgArray[j]).style('width', confidences[j] * 100 + '%');
  }
}

// Clear the data in one class
function clearClass(classIndex) {
  knn.clearClass(classIndex);
}

function updateTranslation(results) {
  // Display different translation
  if (results.classIndex < 0) return;
  if (outputSrc !== msgArray[results.classIndex]) {
    outputSrc = msgArray[results.classIndex];
    if(outputSrc === 'NO'){
      outputSrc = 'No sign';
    }
    select('#output').html(outputSrc);
  }
}

function updateExampleCounts() {
  let counts = knn.getClassExampleCount();
  exampleCounts = counts.slice(0, NUM_CLASSES);
  exampleCounts.forEach((count, index) => {
    select('#example' + msgArray[index]).html(count + ' ex.');
  });
  updateIsPredicting();
}

function updateIsPredicting() {
  prevIsPredicting = isPredicting;
  isPredicting = exampleCounts.some(e => e > 0);
  if (prevIsPredicting !== isPredicting) {
    if (isPredicting) {
      predict();
    } else {
      clearTimeout(predictimer);
      resetResult();
    }
  }
}

function resetResult() {
  select('#output').html("Need calibration");
  updateConfidence(exampleCounts);
}

function activateCam(){
  validCam=1;
  resetSetup();
  resetDraw();
  document.getElementById("activatecam").style.display = "none";  
}