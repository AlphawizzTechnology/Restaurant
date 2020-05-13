<div class="page-wrapper">
	 <div class="content">
	 	<div class="row">
	 		<div class="col-sm-8 col-6 ml-3">
                        <h4 class="page-title">Add Loan Amount</h4>
            </div>
	 	</div>
	 	<div class="row">
	 		
	 		<!-- <div class="col-sm-2"></div> -->
	 		
		 		<div class="col-sm-8" class="amount_box">
		 			<?php if($this->session->flashdata('loan_result')): ?>
		 				<div class="<?=$this->session->flashdata('loan_result_class') ?>"><?= $this->session->flashdata('loan_result') ?></div>
		 			<?php endif; ?>
		 			<form action="<?= base_url() ?>Loan/setLoanAmount" method="post">
				 		<div class="col-sm-12">
				 			<div class="form-group">
					 			<label>Enter Loan Amount</label>
					 			<input type="text" class="form-control" name="loan_amount" value="<?= set_value('loan_amount') ?>">
					 			<?= form_error('loan_amount'); ?>
				 		    </div>
				 		</div>   
			             
			            <div class="col-sm-12">
				 		    <div class="form-group">
					 			<label>Enter Loan Intrest</label>
					 			<input type="text" class="form-control" name="loan_intrest" value="<?= set_value('loan_intrest') ?>">
					 			<?= form_error('loan_intrest'); ?>
				 		    </div>
				 		</div>    

						<div class="col-sm-12">
							<div class="form-group">
								<label>Enter Weekly Pay Amount</label>
								<input type="text" class="form-control" name="weekly_payment" value="<?= set_value('weekly_payment') ?>">
								<?= form_error('weekly_payment'); ?>
							</div>
						</div>

						<div class="col-sm-12">
							<button class="btn btn-primary">Add Amount</button>
						</div>
			 		</form>  
		             
		 		</div>
	 	  
	 		<div class="col-sm-4"></div>
	 	</div>	
	 </div>	
</div>	 	