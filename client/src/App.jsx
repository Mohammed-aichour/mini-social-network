import React, { useState } from 'react';

export default function App() {
  const [posts, setPosts] = useState([
    {
      id: 1,
      author: 'Mohammed AICHOUR',
      role: 'Full-Stack Software Engineer',
      content: 'Bienvenue sur Mini Social Network ! Une architecture full-stack modulaire basée sur React en frontend et une API RESTful PHP native optimisée avec base MySQL.',
      likes: 12,
      comments: 3,
      date: 'À l’instant'
    },
    {
      id: 2,
      author: 'Tech Innovator',
      role: 'Community Member',
      content: 'Excellente séparation des responsabilités entre controllers, models, auth middleware et structure de base de données relationnelle indexée.',
      likes: 8,
      comments: 1,
      date: 'Il y a 2h'
    }
  ]);
  const [newContent, setNewContent] = useState('');

  const handlePost = (e) => {
    e.preventDefault();
    if (!newContent.trim()) return;
    const newEntry = {
      id: Date.now(),
      author: 'Mohammed AICHOUR',
      role: 'Software Architect',
      content: newContent,
      likes: 0,
      comments: 0,
      date: 'À l’instant'
    };
    setPosts([newEntry, ...posts]);
    setNewContent('');
  };

  return (
    <div style={{ maxWidth: '720px', margin: '0 auto', padding: '2rem 1rem' }}>
      <header style={{ marginBottom: '2rem', borderBottom: '1px solid #1e293b', paddingBottom: '1rem' }}>
        <h1 style={{ fontSize: '1.5rem', fontWeight: 'bold', color: '#38bdf8' }}>Mini Social Network</h1>
        <p style={{ color: '#94a3b8', fontSize: '0.875rem' }}>Architecture Full-Stack : React + PHP REST API + MySQL</p>
      </header>

      <form onSubmit={handlePost} style={{ background: '#0f172a', padding: '1.25rem', borderRadius: '0.75rem', border: '1px solid #1e293b', marginBottom: '2rem' }}>
        <textarea
          value={newContent}
          onChange={(e) => setNewContent(e.target.value)}
          placeholder="Exprimez-vous ou partagez une mise à jour technique..."
          rows={3}
          style={{ width: '100%', background: '#1e293b', border: '1px solid #334155', borderRadius: '0.5rem', color: '#fff', padding: '0.75rem', outline: 'none', resize: 'vertical' }}
        />
        <div style={{ display: 'flex', justifyContent: 'flex-end', marginTop: '0.75rem' }}>
          <button
            type="submit"
            style={{ background: '#0284c7', color: '#fff', padding: '0.5rem 1.25rem', borderRadius: '0.5rem', border: 'none', cursor: 'pointer', fontWeight: 600 }}
          >
            Publier
          </button>
        </div>
      </form>

      <div style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
        {posts.map((post) => (
          <article key={post.id} style={{ background: '#0f172a', padding: '1.25rem', borderRadius: '0.75rem', border: '1px solid #1e293b' }}>
            <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '0.75rem' }}>
              <div>
                <h3 style={{ fontSize: '1rem', fontWeight: 600, color: '#f8fafc' }}>{post.author}</h3>
                <span style={{ fontSize: '0.75rem', color: '#64748b' }}>{post.role}</span>
              </div>
              <span style={{ fontSize: '0.75rem', color: '#64748b' }}>{post.date}</span>
            </div>
            <p style={{ color: '#cbd5e1', lineHeight: '1.5', fontSize: '0.95rem' }}>{post.content}</p>
            <div style={{ display: 'flex', gap: '1.5rem', marginTop: '1rem', paddingTop: '0.75rem', borderTop: '1px solid #1e293b', color: '#94a3b8', fontSize: '0.85rem' }}>
              <span>❤️ {post.likes} J'aime</span>
              <span>💬 {post.comments} Commentaires</span>
            </div>
          </article>
        ))}
      </div>
    </div>
  );
}
