# MindEase – AI Mental Health Wellbeing Web Application

## Overview

MindEase is an AI-powered mental health wellbeing web application designed to help users monitor their emotional wellbeing, reflect on their daily feelings, and access supportive mental health tools in one platform.

The system provides a safe and user-friendly environment where users can perform mood analysis, communicate with an AI chatbot, schedule therapy appointments, and monitor their emotional trends over time.

> **Note:** MindEase is intended to provide mental wellness support only. It is **not** a replacement for professional medical diagnosis, therapy, or emergency mental health services. AI-based mental health tools should be presented as supportive rather than as substitutes for professional care. :contentReference[oaicite:0]{index=0}

---

# Features

### User Management
- User Registration
- User Login & Authentication
- Secure Session Management
- Profile Management

### Mood Analysis
- Daily mood check-in
- Mood intensity rating
- Personal journal entry
- AI-based mood score calculation
- Personalized wellbeing recommendations

### Weekly Mood Analysis
- View mood history
- Weekly wellbeing score
- Mood trend visualization using Chart.js
- Average mood score calculation

### AI Mental Health Chatbot
- AI-powered emotional support chatbot
- Text-based conversation
- Mental wellness guidance
- Conversation history

### Therapy Appointment Booking
- View therapist schedules
- Book appointments
- Appointment status tracking
- Appointment history

---

# Technologies Used

### Frontend
- HTML5
- CSS3
- JavaScript
- Bootstrap Icons
- Chart.js

### Backend
- PHP

### Database
- MySQL

### Development Environment
- XAMPP
- phpMyAdmin
- Visual Studio Code

---

#Database Tables

The application consists of the following database tables:
- user
- mood_logs
- appointments
- therapist_schedule
- aichat

---

# Installation

## Requirements
- PHP 8.x
- MySQL
- XAMPP
- Web Browser

---
## Steps
### 1. Clone the project

```bash
git clone https://github.com/yuennt/MindEase.git
```
or download the ZIP file.
### 2. Copy into XAMPP
Move the project folder into
```
xampp/htdocs/
```
---
### 3. Start XAMPP
Start
- Apache
- MySQL
---

### 4. Create Database
Open phpMyAdmin
Create database
```
mindEase
```
Import
```
database.sql
```
---

### 5. Open the application

```
http://localhost/MindEase/login.php
```

---

# System Workflow
1. User registers an account.
2. User logs into the system.
3. User records their daily mood.
4. The system analyzes the mood and generates a wellbeing score.
5. Mood information is stored in the database.
6. Users can view weekly mood trends.
7. Users may chat with the AI assistant.
8. Users can schedule therapist appointments.

---
# Mood Analysis

The mood analysis module calculates a wellbeing score based on:
- Selected mood
- Mood intensity
- Journal sentiment
- Positive keywords
- Negative keywords

The system generates:
- Wellbeing Score (0–100)
- Emotional Status
- Personalized Recommendation

---

# AI Chatbot
The chatbot assists users by:
- Answering mental wellbeing questions
- Providing emotional support
- Offering stress management suggestions
- Encouraging healthy coping strategies

---

#  Weekly Mood Dashboard
The dashboard displays:
- Average wellbeing score
- Mood history
- Weekly trend chart
- Daily mood records

---

# Security Features
- Password authentication
- PHP session management
- Prepared SQL statements
- Input validation
- SQL injection prevention
- XSS protection using `htmlspecialchars()`

---

# Future Improvements
- Password encryption using `password_hash()`
- Email verification
- Password reset
- Push notifications
- AI sentiment analysis using NLP
- Therapist dashboard
- Admin dashboard
- Mobile application
- Emergency contact support

---
# Developers
**MindEase**
AI Mental Health Wellbeing Application
Developed as a Capstone Project II.

---

# License
This project is developed for educational purposes only.
---

# Disclaimer
MindEase is designed to support mental wellbeing through mood tracking, journaling, and AI-assisted conversations. It does not provide medical diagnoses or treatment and should not be relied upon in emergencies. Users experiencing a mental health crisis should contact local emergency services or a qualified mental health professional. Research on mental health applications highlights the importance of transparency, privacy, and positioning AI as supportive rather than a replacement for clinical care. :contentReference[oaicite:1]{index=1}
