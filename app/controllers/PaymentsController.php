<?php

class PaymentsController extends BaseController {

	/**
	 * Payment Repository
	 *
	 * @var Payment
	 */
	protected $payment;

	public function __construct(Payment $payment)
	{
		$this->payment = $payment;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$payments = $this->payment->all();

		return View::make('payments.index', compact('payments'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('payments.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();

        if ( is_array( $input['summ'] ) ) {
            for ( $i = 0; $i < 10; $i ++ ) {
                if ( isset( $input['summ'][$i] ) and (float)$input['summ'][$i] > 0 ) {
                    $data = array(
                                  '_token' => $input['_token'],
								  'created_at' => $input['created_at'],
								  'name' => $input['name'][$i],
								  'section' => $input['section'][$i],
								  'category' => $input['category'][$i],
								  'company' => $input['company'],
								  'summ' => $input['summ'][$i]
                            );

                    $validation = Validator::make($data, Payment::$rules);

                    if ($validation->passes()) {
                        $this->payment->create($data);
                    }
                }
            }
            return Redirect::route('payments.index');
        } else {

    		$validation = Validator::make($input, Payment::$rules);

    		if ($validation->passes())
	    	{
		    	$this->payment->create($input);

    			return Redirect::route('payments.index');
	    	}
        }

		return Redirect::route('payments.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$payment = $this->payment->findOrFail($id);

		return View::make('payments.show', compact('payment'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$payment = $this->payment->find($id);

		if (is_null($payment))
		{
			return Redirect::route('payments.index');
		}

		return View::make('payments.edit', compact('payment'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, Payment::$rules);

		if ($validation->passes())
		{
			$payment = $this->payment->find($id);
			$payment->update($input);

			return Redirect::route('payments.index');
		}

		return Redirect::route('payments.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->payment->find($id)->delete();

		return Redirect::route('payments.index');
	}

}
