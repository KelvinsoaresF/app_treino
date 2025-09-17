CREATE DATABASE IF NOT EXISTS treino;
USE treino;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    role VARCHAR(50) DEFAULT 'user',
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS training_days (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    day VARCHAR(20) NOT NULL,  
    name VARCHAR(100) NOT NULL, 
    start TIME,
    end TIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS exercises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    training_day_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (training_day_id) REFERENCES training_days(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS sets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    exercise_id INT NOT NULL,
    reps INT NOT NULL,      
    carga DECIMAL(6,2),      
    obs TEXT,                
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (exercise_id) REFERENCES exercises(id) ON DELETE CASCADE
);

CREATE IF NOT EXISTS prof_aluno (
id int AUTO_INCREMENt PRIMARY key,
prof_id int not null,
aluno_id int not null,

FOREIGN key (aluno_id) REFERENCES users(id) on DELETE CASCADE,

FOREIGN key (prof_id) REFERENCES users(id) on DELETE CASCADE,

constraint chk_prof_aluno check (prof_id <> aluno_id),
UNIQUE (prof_id, aluno_id)
);
