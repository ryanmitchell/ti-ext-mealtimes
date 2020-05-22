<?php namespace Thoughtco\Mealtimes;

use Event;
use Admin\Widgets\Form;
use Admin\Models\Mealtimes_model;
use System\Classes\BaseExtension;
use Carbon\Carbon;

/**
 * Mealtime Extension Information File
**/
class Extension extends BaseExtension
{
    public function boot()
    {
	    
        // extend column headers in mealtimes list
        Event::listen('admin.list.overrideHeaderValue', function ($column, $value) {
            
            if ($column->model instanceof \Admin\Models\Mealtimes_model) {
	            
	            if ($value->columnName == 'start_time'){
		            return lang('thoughtco.mealtimes::default.start_date');
	            } else if ($value->columnName == 'end_time'){
		            return lang('thoughtco.mealtimes::default.end_date');
	            }
	            
	        }
            
        });			    
	    
        // extend columns in mealtimes list
        Event::listen('admin.list.overrideColumnValue', function ($record, $column, $value, $value2) {
            
            if ($record->model instanceof \Admin\Models\Mealtimes_model) {
	            	            	            
	            if ($value->columnName == 'start_time' || $value->columnName == 'end_time'){
		            
					$dateTime = make_carbon($value->columnName == 'start_time' ? $column->start_date : $column->end_date);
		            
					$format = $value->format ?? setting('date_format');
					$format = parse_date_format($format);

					return $format ? $dateTime->format($format) : $dateTime->toDayDateTimeString($format);		            
		            
	            }
	            	            
	        }
            
        });
	    
        // extend fields mealtimes model
        Event::listen('admin.form.extendFieldsBefore', function (Form $form) {
	        
	        // if its a menuitem model	        
            if ($form->model instanceof \Admin\Models\Menus_model) {
	            
				$form->tabs['fields']['mealtime_id']['label'] = 'lang:thoughtco.mealtimes::default.menu_schedule';            
				unset($form->tabs['fields']['mealtime_id']['comment']);
					            
	        }
            
	        // if its a mealtimes model	        
            if ($form->model instanceof \Admin\Models\Mealtimes_model) {
	            
	            // remove time fields
	            unset($form->fields['start_time']);
	            unset($form->fields['end_time']);
	            
				$form->fields['mealtime_name']['label'] = 'lang:thoughtco.mealtimes::default.menu_name';
	            
				$form->fields['start_date'] = [
				 	 'label' => 'lang:thoughtco.mealtimes::default.start_date',
			         'type' => 'datepicker',
			         'mode' => 'datetime',
			    ];	 
			    
				$form->fields['end_date'] = [
				 	 'label' => 'lang:thoughtco.mealtimes::default.end_date',
			         'type' => 'datepicker',
			         'mode' => 'datetime',
			    ];			
			    
			    $form->fields['availability'] = [
				 	 'label' => 'lang:thoughtco.mealtimes::default.availability',
				 	 'type' => 'partial',
				 	 'path' => 'extensions/thoughtco/mealtimes/partials/flexible',
			    ];  

            }
            
        });
        
		// extend validation in menus model       
		\Admin\Models\Mealtimes_model::extend(function ($model) {
			
			$model->casts['availability'] = 'serialize';
			
			$model->addDynamicMethod('isAvailableSchedule', function($date) use ($model) {
				
			    if ($date === null) $date = Carbon::now();
			    
		        $isBetween = $date->between(
		            Carbon::createFromFormat('Y-m-d H:i:s', $model->start_date),
		            Carbon::createFromFormat('Y-m-d H:i:s', $model->end_date)
		        );
		        		        
		        if (!$isBetween) return false;
		                
		        foreach ($model->availability as $a){
			        			        
			        if ($a['day'] == ($date->format('w') + 6)%7){
				        
				        if ($a['status'] == 0) return false;

				        return $date->between(
				            Carbon::createFromFormat('Y-m-d H:i', $date->format('Y-m-d ').$a['open']),
				            Carbon::createFromFormat('Y-m-d H:i', $date->format('Y-m-d ').$a['close'])
				        );
				        
			        }
		        }
		        
		        return true;
        
        	});
        	
	    });   
	    
		// extend validation in locations and menus models        
		Event::listen('system.formRequest.extendValidator', function ($formRequest, $dataHolder) {
			
			// loctions or menu model dont let us over-ride rules so we take a different approach
		    if ($formRequest instanceof \Admin\Requests\Mealtime){
			    
			    // remove time fields rules
		    	unset($dataHolder->rules['start_time']);
		    	unset($dataHolder->rules['end_time']);
		    	
		    	$dataHolder->rules[] = ['start_date', 'lang:thoughtco.mealtimes::default.start_date', 'required'];
		    	$dataHolder->rules[] = ['end_date', 'lang:thoughtco.mealtimes::default.end_date', 'required'];
		    	
			}
		    
		});	    

    }
    
    public function registerNavigation()
    {
        return [
            'kitchen' => [
                'child' => [
                    'mealtimes' => [
                        'priority' => 99,
                        'class' => 'pages',
                        'href' => admin_url('mealtimes'),
                        'title' => lang('lang:thoughtco.mealtimes::default.menus'),
                        'permission' => 'Admin.Mealtimes',
                    ],
                ],
            ],
        ];
    }    

}

?>