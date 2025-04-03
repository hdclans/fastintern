// Fonction pour afficher ou masquer le formulaire
function toggleForm() {
    const form = document.getElementById('offreForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

// Fonction pour pré-remplir le formulaire lors de la modification d'une offre
function editOffre(id, titre, description, remuneration, date_debut, date_fin, nom_entreprise) {
    document.getElementById('formTitle').textContent = 'Modifier l\'offre';
    document.getElementById('id_offre').value = id;
    document.getElementById('titre').value = titre;
    document.getElementById('description').value = description;
    document.getElementById('remuneration').value = remuneration;
    document.getElementById('date_debut').value = date_debut;
    document.getElementById('date_fin').value = date_fin;
    document.getElementById('nom_entreprise').value = nom_entreprise;
    toggleForm();
}

// Fonction pour confirmer la suppression d'une offre
function deleteOffre(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')) {
        window.location.href = `/?uri=admin/offres/delete&id=${id}`;
    }
}