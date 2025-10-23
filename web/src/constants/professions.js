export const PROFESSIONS = [
  "Médecin",
  "Dentiste",
  "Psychologue",
  "Psychiatre",
  "Infirmier",
  "Kiné/Physiothérapeute",
  "Ostéopathe",
  "Naturopathe",
  "Coach bien-être",
  "Diététicien",
  "Sophrologue",

  "Coiffeur",
  "Esthéticienne",
  "Maquilleur",
  "Manucure",
  "Massage Bien-être",
  "Spa Praticien",

  "Coach personnel",
  "Entraîneur sportif",
  "Professeur de yoga",
  "Instructeur de pilates",
  "Coach CrossFit",
  "Moniteur de natation",

  "Professeur",
  "Formateur",
  "Coach d'apprentissage",
  "Tuteur privé",
  "Cours particuliers",

  "Consultant",
  "Coach professionnel",
  "Consultant RH",
  "Consultant IT",
  "Développeur Web",

  "Comptable",
  "Expert-comptable",
  "Conseiller financier",
  "Consultant fiscal",

  "Designer graphique",
  "Designer UX/UI",
  "Designer d'intérieur",
  "Architecte",
  "Photographe",
  "Videographe",

  "Musicien",
  "Professeur de musique",
  "Professeur de danse",
  "Artiste",
  "Peintre",

  "Avocat",
  "Notaire",
  "Juriste",
  "Médiateur",

  "Agent immobilier",
  "Consultant immobilier",

  "Coach de vie",
  "Coach parental",
  "Coach de carrière",
  "Mentor professionnel",

  "Consultante en image",
  "Consultante en mariage",
  "Wedding planner",
  "Event planner",
  "Traiteur",
  "Chef cuisinier",
  "Pâtissier",
  "Boulanger",
];

/**
 * Fonction pour filtrer la liste des professions
 * @param {string} search - Le texte de recherche
 * @returns {string[]} - Les professions filtrées
 */
export function filterProfessions(search) {
  if (!search.trim()) {
    return PROFESSIONS;
  }

  const lowerSearch = search.toLowerCase();
  return PROFESSIONS.filter((profession) =>
    profession.toLowerCase().includes(lowerSearch)
  );
}
