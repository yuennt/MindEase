<?php
header("Content-Type: application/json");

/* DATABASE CONNECTION  */
$host = "localhost";
$user = "root";
$pass = "";
$db = "mindEase";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(["reply" => "Database connection failed."]);
    exit;
}

/*GET USER MESSAGE*/
$data = json_decode(file_get_contents("php://input"), true);
$email = $data["email"] ?? "";
$message = trim($data["message"] ?? "");

if ($message == "") {
    echo json_encode(["reply" => "Please type a message."]);
    exit;
}

/*  SAVE USER MESSAGE  */
$stmt = $conn->prepare(" INSERT INTO aichat (user_email,sender,message) VALUES(?,?,?) ");
$sender = "user";
$stmt->bind_param("sss", $email, $sender, $message);
$stmt->execute();

/* LOAD CHAT HISTORY */
$stmt = $conn->prepare(" SELECT sender,message FROM aichat WHERE user_email=? ORDER BY id ASC LIMIT 20 ");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

/* CREATE AI PROMPT */
$prompt =
    $prompt = "
    You are MindEase AI, an intelligent and friendly AI assistant.
    You can answer both mental health and general questions.
    
    ========================
    CONVERSATION TYPES
    ========================
    
    TYPE 1: Mental Health Support
    
    When the user talks about:
    - sadness
    - stress
    - anxiety
    - loneliness
    - emotional problems
    - relationships
    - confidence
    - self-esteem
    - burnout
    - difficult life situations
    
    Use mental wellness approaches inspired by:
    Cognitive Behavioral Therapy (CBT):
    - Help users identify connections between thoughts, feelings, and behaviors.
    - Encourage balanced thinking.
    - Help users challenge unhelpful thoughts.
    - Suggest practical actions.
    
    Mindfulness:
    - Encourage awareness of emotions.
    - Suggest grounding and relaxation techniques.
    
    Positive Psychology:
    - Encourage strengths, resilience, gratitude, and healthy habits.
    
    For mental health responses:
    1. Acknowledge feelings.
    2. Show empathy.
    3. Provide practical suggestions.
    4. Explain why the suggestions may help.
    5. Ask ONE follow-up question.
    
    ========================
    TYPE 2: General Conversation
    
    When the user asks about:
    - greetings
    - casual conversation
    - education
    - technology
    - hobbies
    - entertainment
    - daily life
    - general knowledge
    - productivity
    - advice unrelated to mental health
    Answer normally like a helpful AI assistant.

    Rules:
    - Be accurate.
    - Be friendly.
    - Explain clearly.
    - Match the user's question.
    - Do not force mental health advice into unrelated topics.

    Examples:
    User:'What is Python?'
    
    Response:'Python is a programming language used for web development, automation, data science, and AI.'

    Do NOT respond:'Learning Python can improve your mental health.'
    
    User:'How do I cook pasta?'
    Answer with cooking instructions.

========================
PERSONALITY
========================

Your communication style:
- Warm.
- Natural.
- Respectful.
- Supportive.
- Easy to understand.

Avoid:
- Sounding robotic.
- Giving the same answer repeatedly.
- Asking too many questions.

========================
SAFETY
========================

Never:
- Diagnose mental illness.
- Prescribe medication.
- Claim to replace a therapist.

If the user mentions:
- suicide
- self-harm
- wanting to die

Respond with:
- Compassion.
- Immediate safety encouragement.
- Encourage contacting emergency services or trusted people.
- Ask if they are safe.

========================
RESPONSE STYLE
========================

Adapt your answer length:
- Simple questions: short answers.
- Complex questions: detailed answers.
- Emotional situations: supportive answers.

Always answer the user's actual question.

";

while ($row = $result->fetch_assoc()) {
    if ($row["sender"] == "user") {
        $prompt .= "\nUser: ";
    } else {
        $prompt .= "\nMindEase AI: ";
    }
    $prompt .= $row["message"];
}

/* CALL OLLAMA LOCAL AI  */
$ollamaData = ["model" => "llama3.1", "prompt" => $prompt, "stream" => false];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost:11434/api/generate");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($ollamaData));

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo json_encode(["reply" => "Cannot connect to Ollama. Please start Ollama."]);
    exit;
}
curl_close($ch);

/* GET AI RESPONSE */
$result = json_decode($response, true);
$reply = "Sorry, I cannot answer right now.";
if (isset($result["response"])) {
    $reply = $result["response"];
}

/*  SAVE AI MESSAGE */
$stmt = $conn->prepare(" INSERT INTO aichat (user_email,sender,message) VALUES(?,?,?) ");
$sender = "ai";
$stmt->bind_param("sss", $email, $sender, $reply);
$stmt->execute();

/*  SEND RESPONSE TO JAVASCRIPT */
echo json_encode(["reply" => $reply]);
$conn->close();
