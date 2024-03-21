@include('head')
<br><br>
<div id="contenido-a-imprimir" style="width: 100%; margin: 0 auto; max-width: 800px; position: relative; text-align: center;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
        <br><br><br><br><br><br>
        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 50%; opacity: 0.2;">
    </div>

    <div style="width: 80%; margin: 0 auto; padding-top: 50px; text-align: left;">
        <div style="white-space: nowrap; text-align: center;">
            <h1
                style="display: inline; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold; margin-right: 10px;">
                SENA Empresa</h1>
            <p style="display: inline; font-family: Arial, sans-serif; font-size: 11px; font-weight: bold;">“LA
                ANGOSTURA”</p>
        </div>



        <br><br>
        <p style="text-align: center; font-family: Arial, sans-serif; font-size: 20px; font-weight: bold;">CERTIFICA</p>
        <br><br>
        @if (isset($aprendiz))
        <p style="text-align: justify; font-family: Arial, sans-serif; font-size: 11px;">
            Que <span style="font-weight: bold; font-style: italic;">{{ $aprendiz->name }}</span>
            <span style="font-weight: bold; font-style: italic;">{{ $aprendiz->last_name }}</span>, identificado(a) con
            <span style="font-weight: bold;">{{ $aprendiz->document_type }}</span> No
            <span style="font-weight: bold; font-style: italic;">{{ $aprendiz->document_number }}</span> de
            <span style="font-weight: bold; font-style: italic;">{{ $aprendiz->expedition_place }}</span>,
            Aprendiz del Tecnólogo en <span style="font-weight: bold; font-style: italic;">{{ $aprendiz->technologist->name }}</span>
            con código de ficha <span style="font-weight: bold;">{{ $aprendiz->technologist->code }}</span>, adelantó labores administrativas en el rol de
            @if ($aprendiz->roles->count() > 0)
                @foreach ($aprendiz->roles as $role)
                    <span style="font-weight: bold;">{{ $role->name }}</span>
                    @if (!$loop->last)
                        {{ 'y ' }}
                    @endif
                @endforeach
            @else
                No se ha asignado ningún rol.
            @endif
            en el marco de la Estrategia SENA Empresa, del Centro de Formación Agroindustrial “LA ANGOSTURA”, Municipio
            de Campoalegre,
            en el periodo del
            <span style="font-weight: bold; font-style: italic;">
                {{ \Carbon\Carbon::parse($aprendiz->senaempresa->start_date)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
            </span>
            al
            <span style="font-weight: bold; font-style: italic;">
                {{ \Carbon\Carbon::parse($aprendiz->senaempresa->end_date)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
            </span>.
            
        </p><br><br>
        
        <p style="text-align: justify; font-family: Arial, sans-serif; font-size: 11px; font-weight: normal; font-style: normal;">

            Dentro de las principales funciones que desarrolló fueron,
            @if ($aprendiz->roles->count() > 0)
                @foreach ($aprendiz->roles as $role)
                    <span style="font-weight: normal; font-style: normal;">{{ $role->description }}</span>
                    @if (!$loop->last)
                        {{ ', ' }}
                    @endif
                @endforeach, entre otras.
            @else
                No se ha asignado ninguna descripción de rol.
            @endif
        </p>
        @else
            <p style="font-family: Arial, sans-serif; font-size: 11px;">No se ha seleccionado ningún aprendiz.</p>
        @endif
        
        
        <p style="font-family: Arial, sans-serif; font-size: 11px;">
            Durante su liderazgo se destacó por ser una persona responsable, honesta, comprometida y proactiva.
        </p><br>
        
        <p style="text-align: justify; font-family: Arial, sans-serif; font-size: 11px;">
            La anterior certificación se expide a petición del interesado(a), en Campoalegre, a los
            {{ \Carbon\Carbon::now()->isoFormat('D [ día(s) del mes de] MMMM [del] YYYY') }}.
        </p><br><br>
        <p><img src="{{ asset('storage/' . $aprendiz->senaempresa->instructor->signature) }}" alt="Firma del Instructor"
            style="max-width: 150px;"></p>

            <p style="font-family: Arial, sans-serif; font-size: 11px; font-weight: bold;">
                {{ $aprendiz->senaempresa->instructor->name }} {{ $aprendiz->senaempresa->instructor->last_name }}<br>
                {{ $aprendiz->senaempresa->instructor->ocupation }}<br>
                {{ $aprendiz->senaempresa->instructor->position }}<br>
                C.C. {{ $aprendiz->senaempresa->instructor->document_number }} de
                {{ $aprendiz->senaempresa->instructor->expedition_place }}<br>
                Cel. {{ $aprendiz->senaempresa->instructor->phone_number }}
            </p>
        </div>
</div>
