require 'pp'

def read_input(file)
  File.open(file)
end

def make_test_case(input)
  test_cases = Array.new

  test_case_num = input.gets.strip
  test_case_num.to_i.times do |case_num|
    test_case = Hash.new

    block_num = input.gets.strip.to_i
    test_case['naomi_blocks'] = input.gets.strip.split.map{|b| b.to_f }.sort
    test_case['ken_blocks']   = input.gets.strip.split.map{|b| b.to_f }.sort

    test_cases << test_case
  end
  test_cases
end

def solver(test_case)
  test_case_d = Marshal.load(Marshal.dump(test_case))
  test_case_w = Marshal.load(Marshal.dump(test_case))

  d = deceitful_war(test_case_d)  
  w = war(test_case_w)  
  return "#{d} #{w}"
end

def deceitful_war(test_case)
  naomi_win = 0
  lose_num = test_case['naomi_blocks'].select {|n| n < test_case['ken_blocks'].min }.size

  lose_num.times do
    n_block = test_case['naomi_blocks'].shift
    n_told = test_case['ken_blocks'].max 

    k_block = test_case['ken_blocks'].find {|k| k >= n_told }
    test_case['ken_blocks'].delete(k_block) if k_block
    k_block = test_case['ken_blocks'].shift unless k_block
    naomi_win += 1 if n_block >= k_block
    puts "#{n_block} : #{k_block}"
  end

  while n_block = test_case['naomi_blocks'].shift
    n_told = n_block
    n_told = test_case['ken_blocks'].max if n_block < test_case['ken_blocks'].max

    k_block = test_case['ken_blocks'].find {|k| k > n_told }
    test_case['ken_blocks'].delete(k_block) if k_block

    k_block = test_case['ken_blocks'].shift unless k_block
    naomi_win += 1 if n_block >= k_block

    puts "#{n_block} : #{k_block}"
  end
  naomi_win
end

def war(test_case)
  naomi_win = 0

  while n_block = test_case['naomi_blocks'].shift
    k_block = test_case['ken_blocks'].find {|k| k > n_block }
    test_case['ken_blocks'].delete(k_block) if k_block
    k_block = test_case['ken_blocks'].shift unless k_block
    naomi_win += 1 if n_block >= k_block
  end

  naomi_win
end

input_file = ARGV.shift
input_file = 'sample-attempt.in' if input_file.nil?
input      = read_input(input_file)

test_cases = make_test_case(input)
#puts solver test_cases[2]
#exit

test_cases.each_with_index do |test_case, num|
   puts "Case ##{num + 1}: #{solver test_case}"
end


