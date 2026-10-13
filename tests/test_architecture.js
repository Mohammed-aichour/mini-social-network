import fs from 'node:fs';
import path from 'node:path';
import assert from 'node:assert';

console.log('Running test suite for mini-social-network architecture...');

const requiredFiles = [
  'database/schema.sql',
  'server/index.php',
  'server/routes/api.php',
  'server/config/database.php',
  'server/middleware/authMiddleware.php',
  'server/controllers/AuthController.php',
  'server/controllers/PostController.php',
  'server/controllers/CommentController.php',
  'server/controllers/UserController.php',
  'server/controllers/FollowController.php',
  'server/models/User.php',
  'server/models/Post.php',
  'server/models/Comment.php',
  'server/models/Follow.php',
  'client/package.json',
  'client/src/App.jsx'
];

for (const file of requiredFiles) {
  const fullPath = path.resolve(file);
  assert(fs.existsSync(fullPath), `Missing required file: ${file}`);
  const content = fs.readFileSync(fullPath, 'utf-8');
  assert(content.length > 20, `File is empty or truncated: ${file}`);
}

// Check SQL schema integrity
const schema = fs.readFileSync(path.resolve('database/schema.sql'), 'utf-8');
assert(schema.includes('CREATE TABLE IF NOT EXISTS `users`'), 'Schema missing users table');
assert(schema.includes('CREATE TABLE IF NOT EXISTS `posts`'), 'Schema missing posts table');
assert(schema.includes('CREATE TABLE IF NOT EXISTS `comments`'), 'Schema missing comments table');
assert(schema.includes('CREATE TABLE IF NOT EXISTS `likes`'), 'Schema missing likes table');
assert(schema.includes('CREATE TABLE IF NOT EXISTS `follows`'), 'Schema missing follows table');

console.log('✅ All 16 architectural components verified successfully!');
