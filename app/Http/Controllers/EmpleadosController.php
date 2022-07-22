<?php

namespace App\Http\Controllers;

use App\Models\Empleados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Validator;

class EmpleadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
 
        $datos['empleados']=Empleados::all();
        return $datos;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            
            return response()->json([
                
             'token'=>csrf_token()   
            ],200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    


        $empleadoNuevo=new Empleados();

        try {

            $rules=['Nombre'=>'required','ApellidoPaterno'=>'required','ApellidoMaterno'=>'required','Correo'=>'required|unique:Empleados,Correo'];
            $mensajes=['required'=>'El campo :attribute es requerido','unique'=>'El :attribute ya se encuentra registrado, ingrese otro porfavor'];
            $validator=FacadesValidator::make($request->all(),$rules,$mensajes);
            if($validator->fails()){
                return response()->json(['mensaje'=>$validator->errors()],400);
            }
        
        $empleadoNuevo->Nombre=$request->Nombre;
        $empleadoNuevo->ApellidoPaterno=$request->ApellidoPaterno;
        $empleadoNuevo->ApellidoMaterno=$request->ApellidoMaterno;
        $empleadoNuevo->Correo=$request->Correo;

        
        } catch (\Exception $e) {
            return response()->json([
                'mensaje'=>'Ocurrio un error, revise los campos'
            ],400);
        }

        $empleadoNuevo->save();

        return response()->json([
            'mensaje'=>'Empleado creado con exito',
            'empleado'=>$empleadoNuevo
        ],200);
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
     
        try {
            $empleadobuscado=Empleados::findOrFail($id);

        } catch (\Exception $e) {   
            return response()->json([
                'mensaje'=>'Ocurrio un error, el empleado no existe'],404);
        }
        
            return response()->json([
            'mensaje'=>'Busqueda exitosa',
            'Empleado'=>$empleadobuscado],200);
    
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function edit(Empleados $empleados)
    {
        //
        


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        //
        try {
            $empleadoEncontrado = Empleados::findOrFail($id);    

        } catch (\Exception $e) {
            response()->json([
            'mensaje'=>'El empleado no existe en la Base de Datos'
            ],404);
        }

        $empleadoEncontrado->Nombre=$request->Nombre;
        $empleadoEncontrado->ApellidoPaterno=$request->ApellidoPaterno;
        $empleadoEncontrado->ApellidoMaterno=$request->ApellidoMaterno;
        $empleadoEncontrado->Correo=$request->Correo;
        
        $empleadoEncontrado->update();

        return response()->json([
            'mensaje'=>"Empleado Actualizado con exito",
            "empleado"=>$empleadoEncontrado
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        try {
            $eliminado=Empleados::findOrFail($id);
        } catch (\Exception $e) {   
            return response()->json([
                'mensaje'=>'Ocurrio un error ,el empleado no existe'],404);
        }
       
            Empleados::destroy($id);
        
            return response()->json([
            'mensaje'=>'Empleado eliminado con exito',
            'empleado'=>$eliminado],200); 
     
            
    }
        

        
}
