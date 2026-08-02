CREATE DATABASE mindEase;

USE mindEase;

CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(200) NOT NULL,
    confirmPassword VARCHAR(200) NOT NULL,
    profile_image VARCHAR(255) DEFAULT 'default-profile.png'
);

CREATE TABLE appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    therapist_name VARCHAR(100) NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    session_type VARCHAR(50),
    notes TEXT,
    status ENUM(
        'Pending',
        'Approved',
        'Rejected',
        'Completed',
        'Cancelled'
    ) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE aichat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_email VARCHAR(255),
    sender ENUM('user', 'ai'),
    message TEXT,
    image VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE therapist_schedule (
    schedule_id INT AUTO_INCREMENT PRIMARY KEY,
    therapist_name VARCHAR(100) NOT NULL,
    available_date DATE NOT NULL,
    available_time TIME NOT NULL
);

CREATE TABLE mood_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    mood VARCHAR(50) NOT NULL,
    intensity INT NOT NULL,
    journal TEXT,
    emotion VARCHAR(50),
    mood_score INT,
    recommendation TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id)
);

INSERT INTO
    user (
        name,
        email,
        password,
        confirmPassword
    )
VALUES (
        'amy',
        'amy@gmail.com',
        'Pa$$w0rd',
        'Pa$$w0rd'
    ),
    (
        'johnny',
        'johnny@gmail.com',
        'P@ssw0rd123',
        'P@ssw0rd123'
    ),
    (
        'cecilia',
        'lia@gmail.com',
        'Hell0Pswd!',
        'Hell0Pswd!'
    ),
    (
        'lily',
        'lily@gmail.com',
        'MyP@ssword123',
        'MyP@ssword123'
    ),
    (
        'michael',
        'michael@gmail.com',
        'Pass*123!',
        'Pass*123!'
    ),
    (
        'tom',
        'tom@gmail.com',
        'P$w123!',
        'P$w123!'
    );

INSERT INTO
    therapist_schedule (
        therapist_name,
        available_date,
        available_time
    )
VALUES (
        'Emily Carter',
        '2026-08-05',
        '09:00:00'
    ),
    (
        'Emily Carter',
        '2026-08-05',
        '10:00:00'
    ),
    (
        'Emily Carter',
        '2026-08-05',
        '11:00:00'
    ),
    (
        'Michael Brown',
        '2026-08-05',
        '14:00:00'
    ),
    (
        'Michael Brown',
        '2026-08-05',
        '15:00:00'
    ),
    (
        'Sophia Wilson',
        '2026-08-05',
        '09:00:00'
    ),
    (
        'Sophia Wilson',
        '2026-08-05',
        '13:00:00'
    );