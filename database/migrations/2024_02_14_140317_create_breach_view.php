<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE VIEW incumplimiento as
        SELECT 
        `sp_requests`.`id` AS `id`,
        `sp_requests`.`folio` AS `folio`,
        `sp_requests`.`nombre` AS `nombre`,
        `sp_requests`.`app` AS `app`,
        `sp_requests`.`apm` AS `apm`,
        `sp_requests`.`tipo_documento` AS `tipo_documento`,
        `sp_requests`.`observaciones` AS `observaciones`,
		`sp_requests`.`created_at` AS `created_at`,
        `sp_requests`.`visto_at` AS `visto_at`,
		`sp_requests`.`respuesta_at` AS `respuesta_at`,
        `sp_requests`.`respuesta` AS `respuesta`,
		`sp_requests`.`completado_at` AS `completado_at`,
        `sp_requests`.`estatus` AS `estatus`,
        `departments`.`department` AS `department`,
        `asuntos`.`asunto` AS `asunto`,
        datediff(`sp_requests`.`completado_at`,`sp_requests`.`created_at`) AS `dias_transcurridos`,
        (TO_DAYS(NOW()) - TO_DAYS(`sp_requests`.`created_at`))
    FROM
        ((`sp_requests`
        JOIN `departments` ON ((`departments`.`id` = `sp_requests`.`id_departamento_destino`)))
        JOIN `asuntos` ON ((`sp_requests`.`id_asunto` = `asuntos`.`id`)))
    WHERE
        ((`sp_requests`.`active` = 1)
			AND (datediff(`sp_requests`.`completado_at`,`sp_requests`.`created_at`) > 5 ) OR (TO_DAYS(NOW()) - TO_DAYS(`sp_requests`.`created_at`) > 5)
            AND ((`sp_requests`.`estatus` = 'ALTA')
            OR (`sp_requests`.`estatus` = 'COMPLETA'))
			AND(isnull(`sp_requests`.`completado_at`) OR (`sp_requests`.`completado_at` > `sp_requests`.`created_at`) ) 
            AND `sp_requests`.`active` = 1
            )
         
    ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS incumplimiento');
    }
};
