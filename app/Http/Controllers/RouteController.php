<?php

namespace App\Http\Controllers;

use App\Models\Trunk;
use App\Models\Rate;
use App\Models\Rule;

class RouteController extends Controller {

	public function index(){
		$trunks = Trunk::where('estado','A')->orderBy('nombre','ASC')->get(['id','nombre'])->toArray();

		$r = [":Cualquiera"];

		foreach($trunks as $trunk){
			array_push($r, $trunk['id'].":".$trunk['nombre']);
		}

		$r = implode(";", $r);

		return view('home.route', ['data'=>$r]);
	}

	public function insert(){
		try {

			$params = request()->all();

			if(!isset($params['id'])){
				// create
				$rate = new Rate();
				$rate->dialprefix = $params['dialprefix'];
				$rate->troncal_id = $params['troncal_id'];
				$rate->es_portado = $params['es_portado'];
				$rate->receptor_id = -1;
				$rate->estado = 'A';
				$rate->save();

			} else {
				// update
				$rate = Rate::find($params['id']);
				$rate->troncal_id = $params['troncal_id'];
				$rate->es_portado = $params['es_portado'];
				$rate->save();
			}

			return response()->json(['sucess'=>true]);

		} catch (\Exception $e) {
			return response()->json(['error'=>$e->getMessage()], 412);
		}
	}

	public function import(){
		/*
		$content = \File::get($file->getPathName());

		$content = explode("\n", $content);

		try {
			foreach($content as $line){

				// Se obtiene el numero y receptor
				$number = trim(substr($line,20,9));
				$receptor = substr($line,43,2);

				//echo "CALL SP_IMPORT('".$number."',".$receptor.");" . PHP_EOL;
				
				\DB::select('CALL SP_IMPORT(?,?)', [$number, (int)$receptor]);
			}
		} catch (Exception $e) {
			return response()->make($e->getMessage(), 422);
		}*/

		try {
			ini_set("memory_limit", '1G');
			ini_set("max_execution_time", 3600);

			$req = request();

			$file = $req->file('filenumbers');

			if(($gestor = fopen($file->getPathName(), "r")) !== FALSE){

				while(($datos = fgetcsv($gestor, 1000, ",")) !== FALSE){

					if(count($datos)>1){
						$numero = trim($datos[0]);
						$receptor = trim($datos[1]);

						\DB::select('CALL SP_IMPORT(?,?)', [$numero, (int)$receptor]);
					}
				}

			} else {
				throw new \Exception("No se pudo abrir el archivo");
			}

			/*
			\Excel::filter('chunk')->load($file->getPathName())->chunk(250, function($results){
				foreach($results as $row){
					
				}
			});*/

			return response('', 204);

			//return response($file->getPathName(), 200);
		} catch (\Exception $e) {
			return response()->make($e->getMessage(), 422);
		}
	}

	public function search(){

		// Obtenemos los inputs
		$p = request()->all();

		$start = ($p['rows']*$p['page']-$p['rows']);

		// 
		$sql = Rate::leftjoin('trunk as t','rate.troncal_id','=','t.id');

		if(isset($p['dialprefix'])){
			$sql->where('rate.dialprefix', 'LIKE', $p['dialprefix']."%");
		}

		if(isset($p['troncal_id']) && $p['troncal_id']>0){
			$sql->where('rate.troncal_id', $p['troncal_id']);
		}

		if(isset($p['es_portado']) && $p['es_portado'] != ""){
			$sql->where('rate.es_portado', $p['es_portado']);
		}

		$records = $sql->count();

		$rates = $sql->orderBy($p['sidx'], $p['sord'])->take($p['rows'])->skip($start)->get(['rate.id','rate.dialprefix','t.nombre','rate.es_portado','rate.troncal_id']);

		if(count($rates)>0){

			$total_pages = 0;

			if( $records >0 ) {	
				$total_pages 	= ceil($records/$p['rows']);
			}

			if ($p['page'] > $total_pages){
				$p['page'] = $total_pages;
			}

			$return = ['page'=>$p['page'],'total'=>$total_pages,'records'=>$records];

			$options = '<button class="btn btn-primary btn-xs no-border btn-edit" data-row-id="[id]" data-rel="tooltip" title data-original-title="Editar" data-placement="right"> <i class="fa fa-pencil bigger-110 icon-only"></i></button> <button class="btn btn-danger btn-xs no-border btn-del" data-row-id="[id]" data-rel="tooltip" title data-original-title="Eliminar" data-placement="right"> <i class="fa fa-trash red"></i></button>';

			$i=0;
			$rates = $rates->toArray();
			foreach($rates as $rate){
				$return['rows'][$i] = $rate;
				$return['rows'][$i]['es_portado'] = ($rate['es_portado']==0?"No":"Si");
				$return['rows'][$i]['es_portado_id'] = $rate['es_portado'];
				$return['rows'][$i]['opcion'] = str_replace('[id]', $rate['dialprefix'], $options);

				$i++;
			}

			return response()->json($return);
		} else {
			return response()->json([]);
		}
	}
}