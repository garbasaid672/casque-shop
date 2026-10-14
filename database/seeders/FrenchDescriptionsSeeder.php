<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

// Remplace les descriptions de démonstration en latin par de vrais textes en français.
class FrenchDescriptionsSeeder extends Seeder
{
    public function run(): void
    {
        // [nom exact du produit => [description, description courte]]
        $texts = [
            'Anker Soundcore Space Q45' => [
                'Le casque Anker Soundcore Space Q45 offre une réduction de bruit adaptative, un son détaillé grâce aux doubles transducteurs et une autonomie exceptionnelle de 50 heures. Idéal pour les longs voyages comme pour le bureau.',
                'Réduction de bruit adaptative et 50h d’autonomie.',
            ],
            'Apple AirPods Max' => [
                'Le casque Apple AirPods Max combine un design en aluminium, un son haute-fidélité et la réduction de bruit active. La couronne Digital Crown permet de régler le volume avec précision, pour une expérience premium.',
                'Le casque premium d’Apple, son haute-fidélité.',
            ],
            'Beats Studio Pro' => [
                'Le Beats Studio Pro délivre un son puissant avec des basses profondes, une réduction de bruit active et un mode transparence. Jusqu’à 40 heures d’autonomie pour ne jamais tomber en panne de musique.',
                'Basses puissantes et 40h d’autonomie.',
            ],
            'Bose QuietComfort Ultra' => [
                'Le Bose QuietComfort Ultra, référence de la réduction de bruit, enveloppe vos oreilles d’un silence absolu avec un son immersif et un confort légendaire, même après des heures d’écoute.',
                'La référence Bose de la réduction de bruit.',
            ],
            'Bowers & Wilkins Px8' => [
                'Le Bowers & Wilkins Px8 marie cuir Nappa, aluminium et transducteurs en carbone pour un son digne d’une salle de concert. La réduction de bruit adaptative s’ajuste à votre environnement.',
                'Son haute-fidélité et finition cuir Nappa.',
            ],
            'Focal Bathys' => [
                'Le Focal Bathys, premier casque Bluetooth de la marque française, offre un son pur et dynamique grâce à ses transducteurs en aluminium-magnésium, avec réduction de bruit et 30 heures d’autonomie.',
                'L’excellence sonore française en Bluetooth.',
            ],
            'Hifiman Ananda BT' => [
                'Le Hifiman Ananda BT est un casque audiophile à technologie planar-magnétique, en version Bluetooth haute résolution. Une scène sonore large et précise pour les mélomanes exigeants.',
                'Casque planar-magnétique pour audiophiles.',
            ],
            'Meze Audio 99 Classics' => [
                'Le Meze Audio 99 Classics séduit par son design en bois de noyer et son son chaud et naturel. Un casque fermé confortable, parfait pour redécouvrir sa musique.',
                'Design en bois de noyer, son chaud et naturel.',
            ],
            'Puro Sound Labs BT2200' => [
                'Le Puro Sound Labs BT2200 protège les oreilles des enfants en limitant le volume à 85 dB, tout en offrant un son clair en Bluetooth. Léger, pliable et robuste pour un usage quotidien.',
                'Volume limité à 85 dB, idéal pour les enfants.',
            ],
            'Razer Barracuda Pro' => [
                'Le Razer Barracuda Pro est un casque gaming et nomade avec réduction de bruit hybride, son THX et double connexion Bluetooth et 2,4 GHz. Confort longue durée pour jouer comme pour travailler.',
                'Gaming et nomade avec son THX.',
            ],
            'Sennheiser HD 450BT' => [
                'Le Sennheiser HD 450BT propose la signature sonore équilibrée de la marque, une réduction de bruit active et 30 heures d’autonomie, à un prix très accessible.',
                'Le son Sennheiser accessible avec ANC.',
            ],
            'Sennheiser Momentum 4' => [
                'Le Sennheiser Momentum 4 Wireless offre un son audiophile détaillé, une réduction de bruit adaptative et une autonomie record de 60 heures, dans un design élégant et confortable.',
                'Son audiophile et 60h d’autonomie record.',
            ],
            'Shure AONIC 50' => [
                'Le Shure AONIC 50, issu du savoir-faire studio de la marque, délivre un son précis et équilibré avec réduction de bruit réglable et une construction robuste pensée pour durer.',
                'Précision studio Shure en sans fil.',
            ],
            'Skullcandy Crusher Evo' => [
                'Le Skullcandy Crusher Evo fait vibrer vos musiques grâce à ses basses haptiques réglables, avec 40 heures d’autonomie et un suivi Tile intégré pour ne plus le perdre.',
                'Basses haptiques réglables qui font vibrer.',
            ],
            'Sony WH-1000XM5' => [
                'Le Sony WH-1000XM5 est le roi des casques à réduction de bruit : silence absolu, son Hi-Res, appels cristallins et 30 heures d’autonomie dans un design ultraléger et confortable.',
                'Le roi de la réduction de bruit Sony.',
            ],
            'Technics EAH-A800' => [
                'Le Technics EAH-A800 offre un son riche et naturel avec réduction de bruit à 3 micros, 40 heures d’autonomie et une connexion multipoint fluide entre vos appareils.',
                'Son naturel Technics et 40h d’autonomie.',
            ],
        ];

        foreach ($texts as $name => [$description, $short]) {
            Product::where('name', $name)->update([
                'description' => $description,
                'short_description' => $short,
            ]);
        }
    }
}
