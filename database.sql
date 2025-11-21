-- SQL schema for SIM Platform Musik
CREATE DATABASE IF NOT EXISTS music_platform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE music_platform;

DROP TABLE IF EXISTS tracks;
CREATE TABLE tracks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    artist VARCHAR(150) NOT NULL,
    album VARCHAR(150) NOT NULL,
    year INT NOT NULL,
    genre VARCHAR(100) NOT NULL,
    duration VARCHAR(20) NOT NULL,
    cover_url VARCHAR(500) NOT NULL,
    audio_url VARCHAR(500) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample data
INSERT INTO tracks (title, artist, album, year, genre, duration, cover_url, audio_url) VALUES
('Midnight Drive', 'Nova Lights', 'City Pulse', 2023, 'Synthwave', '03:58', 'https://images.unsplash.com/photo-1511379938547-c1f69419868d?w=400', 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3'),
('Sunset Boulevard', 'Golden Hour', 'Neon Skies', 2022, 'Indie Pop', '04:12', 'https://images.unsplash.com/photo-1487215078519-e21cc028cb29?w=400', 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3'),
('Echoes', 'Reverb State', 'Deep Dive', 2024, 'Ambient', '05:05', 'https://images.unsplash.com/photo-1511379938547-c1f69419868d?w=400', 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-3.mp3'),
('Stardust', 'Luna', 'Cosmic Waves', 2021, 'Electronic', '03:35', 'https://images.unsplash.com/photo-1525186402429-b4ff38bedbec?w=400', 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-4.mp3'),
('Backyard Groove', 'LoFi Cafe', 'Chill Beans', 2020, 'Lo-Fi', '02:57', 'https://images.unsplash.com/photo-1511379938547-c1f69419868d?w=400', 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-5.mp3');
