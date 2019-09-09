<?php

use App\Song;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();

        $songsData = [
            [
                "title" => "Deja te conecto",
                "youtube_id" => 'PJr0gJ__BPk',
                "video_start" => 9,
                "lyrics" => '[17.5] No me pidas que llore por ti,
[19.5] [20.5] Alguna vez te vi sometido,
[20.5] [25.5] Tus ojos caen why flotan en la obscuridad,
[25.5] [27.5] Alumbrame, que estoy bien perdido.
why fue una vez, si solo una vez,
Que te dije la verdad, si solo una vez,
Hinchado en alcohol, perdido en la noche,
Soñando con volver, con volver.
why solo quiero que me des un poco de sinceridad,
Why solo quiero que me des un poco de sinceridad.
Dejame verte caer, dejame entrar en tus sueños,
No, no, no es cierto que robaste el grito final
El que esta a la orilla del viento, no
Deja me conecto.
Dejame verte caer, dejame entrar en tus sueños,
No, no, no es cierto que robaste el grito final
El que esta a la orilla del viento, no
Deja me conecto.
No me pidas que llore por ti,
Alguna vez te vi sometido,
Tus ojos caen why flotan en la obscuridad,
Alumbrame, que estoy bien perdido.
why fue una vez, si solo una vez,
Que te dije la verdad, si solo una vez,
Hinchado en alcohol, perdido en la noche,
Soñando con volver, con volver.
why solo quiero que me des un poco de sinceridad,
Why solo quiero que me des un poco de sinceridad.
Dejame verte caer, dejame entrar en tus sueños,
No, no, no es cierto que robaste el grito final
El que esta a la orilla del viento, no
Deja me conecto.
Dejame verte caer, dejame entrar en tus sueños,
No, no, no es cierto que robaste el grito final
El que esta a la orilla del viento, no
Deja me conecto.
Dejame verte...
(Shine on you people of the earth
Try to make it right, love is the way.)',
                "created_at" => $now,
                "updated_at" => $now
            ], [
                "title" => "azul",
                "youtube_id" => '<e4ANL_JebVg',
                "video_start" => 0,
                "lyrics" => 'Tú, qué manera de aferrarte, tú 
Tú, que me orbitas como el sol 
Tú, pegada a la pared
Tú, que habitas en mi mente, tú 
Tú, en cada esquina, tú 
Tú, debajo del mantel
Estoy cayéndome a pedazos por tu ausencia 
Y lo peor es que no quiero verte nunca
Estoy hundiéndome en el hábito de amarte 
Y tú ya me olvidaste
Tu mirada en el retrovisor 
Tú, con el vestido azul 
Tú, llorando en el andén
Estoy cayéndome a pedazos por tu ausencia 
Y lo peor es que no quiero verte nunca
Estoy hundiéndome en el habito de amarte
Y tú ya tienes a otro
Tienes a otro 
Ya tienes otro
Ya me olvidaste
Ah, ya me olvidaste
Oh, ya me olvidaste
Estoy cayéndome a pedazos por tu ausencia 
Y lo peor es que no quiero verte nunca
Estoy hundiéndome en el habito de amarte 
Y tú ya me olvidaste
Ya me olvidaste
Ya tienes otro',
                "created_at" => $now,
                "updated_at" => $now
            ], [
                "title" => "No hay mal que dure",
                "youtube_id" => 'LI_xR-RNvOc',
                "video_start" => 0,
                "lyrics" => 'No tienes remedio
Sientes demasiado
Percibes la lluvia
Pero antes de que caiga
Si alguien te molesta
Por ser diferente
Dales paciencia
Ellos son todos iguales
Tus alas al viento
Salpicando calma
Te nutres de letras
Y de fotografías
En un océano de primigenio
Cariño, grabo tu nombre
Reconozco la oscuridad
De mi alma y me hago más sabio
La música clásica
Te aplaca las penas
Exhalas demencia
Y tratas de no juzgar
En un océano de primigenio
Cariño, grabo tu nombre
Reconozco la oscuridad
De mi alma y me hago más sabio
No hay mal que dure más de 100 años, oh-ooh-oh
Decía mi madre
No hay mal que dure más de 100 años, oh-ooh-oh
Decía mi madre
No hay mal que dure más de 100 años, oh-ooh-oh
Decía mi madre
No hay mal que dure más de 100 años, oh-ooh-oh
Decía mi madre
"Oh", decía mi madre
"Oh", decía mi madre
Pri Chinga tu madre',
                "created_at" => $now,
                "updated_at" => $now
            ]

        ];

        Song::insert($songsData);

    }
}
