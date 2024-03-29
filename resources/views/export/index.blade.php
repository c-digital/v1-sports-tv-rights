<x-template-dashboard active="export">
	<div class="w-full p-7">
        <h1 class="text-3xl mb-4">{{ 'Exportar datos' }}</h1>

        <x-alert></x-alert>

        <div class="content-center items-center bg-white border rounded shadow p-5 text-lg">

        	<form action="/export" id="export" method="POST">
		        <div class="mt-6">
		        	<label class="inline-block w-32" for="league">Competición</label>
		        	<select @change="reloadWithLeague()" name="league" id="league" required>
	        			<option value=""></option>
	        			<option {{ get('league') == 344 ? 'selected' : '' }} value="344">Liga Bolivia</option>
	        			<option {{ get('league') == 964 ? 'selected' : '' }} value="964">Copa Bolivia</option>
	        			<option {{ get('league') == 140 ? 'selected' : '' }} value="140">Liga España</option>
	        			<option {{ get('league') == 143 ? 'selected' : '' }} value="143">Copa del Rey</option>
	        			<option {{ get('league') == 39 ? 'selected' : '' }} value="39">Premier League</option>
	        			<option {{ get('league') == 2 ? 'selected' : '' }} value="2">Champions League</option>
	        			<option {{ get('league') == 3 ? 'selected' : '' }} value="3">Europa League</option>
	        			<option {{ get('league') == 15 ? 'selected' : '' }} value="15">Liga Italia</option>
	        			<option {{ get('league') == 128 ? 'selected' : '' }} value="128">Liga Argentina</option>
	        			<option {{ get('league') == 61 ? 'selected' : '' }} value="61">Liga Francia</option>
	        			<option {{ get('league') == 78 ? 'selected' : '' }} value="78">Liga Alemania</option>
	        		</select>
		        </div>

		        <div class="mt-4">
		        	<label class="inline-block w-32" for="type">Tipo</label>
		        	<select @change="reloadWithType()" id="type" name="type" required>
		        		<option {{ get('type') == 'stadings' ? 'selected' : '' }} value="standings">Tabla de posiciones</option>
		        		<option {{ get('type') == 'fixture' ? 'selected' : '' }} value="fixture">Fixture</option>
		        		<option {{ get('type') == 'lineups' ? 'selected' : '' }} value="lineups">Alineaciones</option>
		        		<option {{ get('type') == 'referees' ? 'selected' : '' }} value="referees">Árbitros</option>
		        		<option {{ get('type') == 'stats' ? 'selected' : '' }} value="stats">Estadísticas</option>
		        		<option {{ get('type') == 'heatMap' ? 'selected' : '' }} value="heatMap">Mapa de calor</option>
		        		<option {{ get('type') == 'score' ? 'selected' : '' }} value="score">Score</option>
		        	</select>
		        </div>

		        @if(! empty($rounds))
		        	<div class="mt-6" id="round-container">
			        	<label class="inline-block w-32" for="round">Fecha</label>
			        	<select @change="reloadWithRound()" name="round" id="round" required>
		        			<option value=""></option>
		        			@foreach($rounds as $round)
		        				<option {{ get('round') == $round ? 'selected' : '' }} value="{{ $round }}">{{ $round }}</option>
		        			@endforeach
		        		</select>
			        </div>
		        @endif

		        @if(! empty($matches) && get('type') != 'fixture' && get('type') != 'standings')
		        	<div class="mt-6" id="match-container">
			        	<label class="inline-block w-32" for="match">Partido</label>
			        	<select name="fixture" id="match" required>
		        			<option value=""></option>
		        			@foreach($matches as $match)
		        				<option {{ get('fixture') == $match->fixture->id ? 'selected' : '' }} value="{{ $match->fixture->id }}">{{ $match->teams->home->name . ' vs ' . $match->teams->away->name }}</option>
		        			@endforeach
		        		</select>
			        </div>
		        @endif

		        <div class="mt-4 mb-6">
		        	<button type="submit" class="bg-blue-tigo text-center items-center p-3 appearance-none bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
		            	<i class="fa fa-spinner mr-2"></i>
	                    Generar
		            </button>

		            @if(get('copy'))
		            	<input type="hidden" id="link" value="{{ linkToCopy() }}">

			            <button type="button" @click="copyToClipboard()" class="bg-blue-tigo text-center items-center p-3 appearance-none bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
			            	<i class="fa fa-copy mr-2"></i>
		                    Copiar enlace
			            </button>
			        @endif
		        </div>
	        </form>
		</div>
    </div>
</x-template-dashboard>